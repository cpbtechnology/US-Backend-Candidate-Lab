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
                Id = id,
                Title = "Go to the Galaxy Game.",
                Description = "Head over to Stub Hub Center in Carson, California for a lovely game of fútbol."
            };
        }

        public Note SaveNote(Note input)
        {
            if (input.Id == 0) { input.Id = 456; }

            return input;
        }

        public Note DeleteNote(int id)
        {
            return new Note()
            {
                Id = id,
                Title = "Go to the Galaxy Game.",
                Description = "Head over to Stub Hub Center in Carson, California for a lovely game of fútbol."
            };
        }
    }
}
