using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Dapper;
using Notesy.Core.Models;
using Notesy.Core.Services.Interfaces;

namespace Notesy.Core.Services.Concrete
{
    public class NoteService : INoteService
    {
        // https://github.com/StackExchange/dapper-dot-net#performance-of-select-mapping-over-500-iterations---poco-serialization
        // Not exactly the best reason but there is something to say about dapper given it's simplicity and speed.  We'll use it here.
        // At this point, we could also just connect to a cloud service or any other data store and the rest of the app wouldn't need to know.  It doesn't
        // have to be a relational database.

        // ASSUMPTIONS: 
        // * All incoming inputs are valid.
        // * New objects have an id of 0.

        public Note GetNote(int id)
        {
            var output = new Note();

            // In most cases, you'd want to at least consider sprocs here rather than raw sql.  
            var sql = @"SELECT 
                            [Id]
                            ,[Title]
                            ,[Description]
                            ,[IsComplete]
                            ,[ApiUserId]
                            ,[DateCreated]
                        FROM 
                            [dbo].[Note]
                        WHERE
                            [Id] = @Id";
            
            using (var connection = new SqlConnection(ConfigurationManager.ConnectionStrings["NOTESY_CORE"].ConnectionString))
            {
                connection.Open();
                var notes = connection.Query<Note>(sql, new { Id = id });
                output = notes.First();  // TODO: lots to talk about in this line of code
            }

            return output;
        }

        public Note SaveNote(Note input)
        {
            var output = new Note();

            var insert = @"INSERT INTO 
	                        [dbo].[Note]
	                            ([Title]
	                            ,[Description]
	                            ,[IsComplete]
	                            ,[ApiUserId]
	                            ,[DateCreated])	
                            VALUES
	                            (@Title,
	                            @Description,
	                            @IsComplete,
	                            @ApiUserId,
	                            @DateCreated)

                            SELECT SCOPE_IDENTITY()";

            var update = @"UPDATE
	                            [dbo].[Note]
                            SET
	                            [Title] = @Title,
	                            [Description] = @Description,
	                            [IsComplete] = @IsComplete,
	                            [ApiUserId] = @ApiUserId,
	                            [DateCreated] = @DateCreated
                            WHERE 
	                            [Id] = @Id";

            if (input.Id == 0)
            {
                // insert
                using (var connection = new SqlConnection(ConfigurationManager.ConnectionStrings["NOTESY_CORE"].ConnectionString))
                {
                    connection.Open();
                    var result = connection.Query<int>(insert, new { Title = input.Title, Description = input.Description, IsComplete = input.IsComplete, ApiUserId = input.ApiUserId, DateCreated = input.DateCreated });
                    output = input;
                    output.Id = result.First();
                }
            }
            else
            {
                // update
                using (var connection = new SqlConnection(ConfigurationManager.ConnectionStrings["NOTESY_CORE"].ConnectionString))
                {
                    connection.Open();
                    var result = connection.Execute(update, new { Id = input.Id, Title = input.Title, Description = input.Description, IsComplete = input.IsComplete, ApiUserId = input.ApiUserId, DateCreated = input.DateCreated });
                    output = input;
                }
            }

            return output;
        }

        public Note DeleteNote(int id)
        {
            var output = GetNote(id);

            var sql = @"DELETE FROM 
	                        [dbo].[Note]
                        WHERE 
	                        [Id] = @Id";

            using (var connection = new SqlConnection(ConfigurationManager.ConnectionStrings["NOTESY_CORE"].ConnectionString))
            {
                connection.Open();
                var result = connection.Execute(sql, new { Id = id });
            }

            return output;
        }
    }
}
