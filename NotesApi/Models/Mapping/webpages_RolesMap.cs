using System.ComponentModel.DataAnnotations.Schema;
using System.Data.Entity.ModelConfiguration;

namespace NotesApi.Models.Mapping
{
    public class webpages_RolesMap : EntityTypeConfiguration<webpages_Roles>
    {
        public webpages_RolesMap()
        {
            // Primary Key
            this.HasKey(t => t.RoleId);

            // Properties
            this.Property(t => t.RoleName)
                .IsRequired()
                .HasMaxLength(256);

            // Table & Column Mappings
            this.ToTable("webpages_Roles");
            this.Property(t => t.RoleId).HasColumnName("RoleId");
            this.Property(t => t.RoleName).HasColumnName("RoleName");

            // Relationships
            this.HasMany(t => t.UserProfiles)
                .WithMany(t => t.webpages_Roles)
                .Map(m =>
                    {
                        m.ToTable("webpages_UsersInRoles");
                        m.MapLeftKey("RoleId");
                        m.MapRightKey("UserId");
                    });


        }
    }
}
