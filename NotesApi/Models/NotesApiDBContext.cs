using System.Data.Entity;
using System.Data.Entity.Infrastructure;
using NotesApi.Models.Mapping;

namespace NotesApi.Models
{
    public partial class NotesApiDBContext : DbContext
    {
        static NotesApiDBContext()
        {
            Database.SetInitializer<NotesApiDBContext>(null);
        }

        public NotesApiDBContext()
            : base("Name=NotesApiDBContext")
        {
        }

        public DbSet<note> notes { get; set; }

        protected override void OnModelCreating(DbModelBuilder modelBuilder)
        {
            modelBuilder.Configurations.Add(new noteMap());
        }
    }
}
