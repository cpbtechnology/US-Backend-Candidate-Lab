using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Notesy.Core.Models;

namespace Notesy.Core.Services.Interfaces
{
    public interface INoteService
    {
        Note GetNote(int id);
        Note SaveNote(Note input);
        Note DeleteNote(int id);
    }
}
