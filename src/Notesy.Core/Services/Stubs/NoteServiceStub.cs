using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Notesy.Core.Models;
using Notesy.Core.Services.Interfaces;

namespace Notesy.Core.Services.Stubs
{
    public class NoteServiceStub : INoteService
    {
        public Note GetNote(int id)
        {
            return new Note()
            {
                Id = 102345,
                Title = "Go to the Galaxy Game.",
                Description = "Head over to Stub Hub Center in Carson, California for lovely game of fútbol."
            };
        }

        public Note SaveNote(Models.Note input)
        {
            throw new NotImplementedException();
        }

        public Note DeleteNote(int id)
        {
            throw new NotImplementedException();
        }
    }
}
