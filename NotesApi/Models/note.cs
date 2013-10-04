using System;
using System.Collections.Generic;

namespace NotesApi.Models
{
    public partial class note
    {
        public int noteId { get; set; }
        public string userToken { get; set; }
        public string note1 { get; set; }
        public System.DateTime lastModified { get; set; }
    }
}
