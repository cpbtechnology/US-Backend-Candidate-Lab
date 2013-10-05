using System.ComponentModel.DataAnnotations;
namespace NotesApi.Models
{
	public partial class note
	{
		public int noteId { get; set; }
		public string userToken { get; set; }
		[Required]
		public string note1 { get; set; }
		public System.DateTime lastModified { get; set; }
	}
}
