using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Notesy.Core.Models
{
    public class Note
    {
        public int Id { get; set; }
        public string Title { get; set; }
        public string Description { get; set; }
        public bool IsComplete { get; set; }

        public Note()
        {
            IsComplete = false;  // this defaults to false but let's be explicit
        }
    }
}
