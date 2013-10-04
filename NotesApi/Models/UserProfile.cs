using System;
using System.Collections.Generic;

namespace NotesApi.Models
{
    public partial class UserProfile
    {
        public UserProfile()
        {
            this.webpages_Roles = new List<webpages_Roles>();
        }

        public int UserId { get; set; }
        public string UserName { get; set; }
        public virtual ICollection<webpages_Roles> webpages_Roles { get; set; }
    }
}
