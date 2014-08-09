using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Notesy.Core.Models
{
    // At this point, if we were using a true ORM we could be linking our models and defining their relationships (such as NHibernate or Entity Framework, etc).  You 
    // could do some of this in code (rather than a config) with Fluent NHibernate or similar library.  For a huge example, see Sharp Architecture: https://github.com/sharparchitecture/Sharp-Architecture/tree/master/Solutions/SharpArch.NHibernate

    public class Note
    {
        public int Id { get; set; }
        public string Title { get; set; }
        public string Description { get; set; }
        public bool IsComplete { get; set; }
        public int ApiUserId { get; set; }   // this is where we could define an ORM relation ship... it'd be something more like: public ApiUser ApiUser { get; set; }, though it would need to be "glued" together with a true ORM 
 
        public Note()
        {
            IsComplete = false;  // this defaults to false but let's be explicit
        }
    }
}
