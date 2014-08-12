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
    public class ApiUserService : IApiUserService
    {
        public ApiUser GetApiUser(int id)
        {
            var output = new ApiUser();

            var sql = @"SELECT 
	                        [Id]
	                        ,[Name]
	                        ,[ApiKey]
	                        ,[ApiSecret]
	                        ,[DateCreated]
                        FROM 
	                        [dbo].[ApiUser]
                        WHERE
                            [Id] = @Id";

            using (var connection = new SqlConnection(ConfigurationManager.ConnectionStrings["NOTESY_CORE"].ConnectionString))
            {
                connection.Open();
                var users = connection.Query<ApiUser>(sql, new { Id = id });
                output = users.First();  
            }

            return output;
        }

        public ApiUser SaveApiUser(ApiUser input)
        {
            var output = new ApiUser();

            var insert = @"INSERT INTO 
	                            [dbo].[ApiUser]
		                            ([Name]
		                            ,[ApiKey]
		                            ,[ApiSecret]
		                            ,[DateCreated])
                            VALUES
	                            (@Name,
	                            @ApiKey,
	                            @ApiSecret,
	                            @DateCreated)

                            SELECT SCOPE_IDENTITY()";

            var update = @"UPDATE 
	                            [dbo].[ApiUser]
                            SET 
	                            [Name] = @Name,
	                            [ApiKey] = @ApiKey,
	                            [ApiSecret] = @ApiSecret,
	                            [DateCreated] = @DateCreated
                            WHERE 
	                            [Id] = @Id";

            if (input.Id == 0)
            {
                // insert
                using (var connection = new SqlConnection(ConfigurationManager.ConnectionStrings["NOTESY_CORE"].ConnectionString))
                {
                    connection.Open();
                    var result = connection.Query<int>(insert, new { Name = input.Name, ApiKey = input.ApiKey, ApiSecret = input.ApiSecret, DateCreated = input.DateCreated });
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
                    var result = connection.Execute(update, new { Name = input.Name, ApiKey = input.ApiKey, ApiSecret = input.ApiSecret, DateCreated = input.DateCreated });
                    output = input;
                }
            }

            return output;
        }

        public ApiUser DeleteApiUser(int id)
        {
            var output = GetApiUser(id);

            var sql = @"DELETE FROM 
	                        [dbo].[ApiUser]
                        WHERE 
	                        [Id] = @Id";

            using (var connection = new SqlConnection(ConfigurationManager.ConnectionStrings["NOTESY_CORE"].ConnectionString))
            {
                connection.Open();
                var result = connection.Execute(sql, new { Id = id });
            }

            return output;
        }


        public ApiUser GetApiUserByApiKey(string apiKey)
        {
            var output = new ApiUser();

            var sql = @"SELECT 
	                        [Id]
	                        ,[Name]
	                        ,[ApiKey]
	                        ,[ApiSecret]
	                        ,[DateCreated]
                        FROM 
	                        [dbo].[ApiUser]
                        WHERE
                            [ApiKey] = @ApiKey";

            using (var connection = new SqlConnection(ConfigurationManager.ConnectionStrings["NOTESY_CORE"].ConnectionString))
            {
                connection.Open();
                var result = connection.Execute(sql, new { ApiKey = apiKey });
            }

            return output;
        }
    }
}
