using System.ComponentModel.DataAnnotations.Schema;
using System.Data.Entity.ModelConfiguration;

namespace NotesApi.Models.Mapping
{
    public class noteMap : EntityTypeConfiguration<note>
    {
        public noteMap()
        {
            // Primary Key
            this.HasKey(t => t.noteId);

            // Properties
            this.Property(t => t.userToken)
                .IsRequired()
                .HasMaxLength(50);

            this.Property(t => t.note1)
                .IsRequired();

            // Table & Column Mappings
            this.ToTable("notes");
            this.Property(t => t.noteId).HasColumnName("noteId");
            this.Property(t => t.userToken).HasColumnName("userToken");
            this.Property(t => t.note1).HasColumnName("note");
            this.Property(t => t.lastModified).HasColumnName("lastModified");
        }
    }
}
