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
        public DbSet<UserProfile> UserProfiles { get; set; }
        public DbSet<webpages_Membership> webpages_Membership { get; set; }
        public DbSet<webpages_OAuthMembership> webpages_OAuthMembership { get; set; }
        public DbSet<webpages_Roles> webpages_Roles { get; set; }

        protected override void OnModelCreating(DbModelBuilder modelBuilder)
        {
            modelBuilder.Configurations.Add(new noteMap());
            modelBuilder.Configurations.Add(new UserProfileMap());
            modelBuilder.Configurations.Add(new webpages_MembershipMap());
            modelBuilder.Configurations.Add(new webpages_OAuthMembershipMap());
            modelBuilder.Configurations.Add(new webpages_RolesMap());
        }
    }
}
