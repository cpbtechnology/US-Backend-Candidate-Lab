using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Notesy.Core.Models;

namespace Notesy.Core.Services.Interfaces
{
    public interface IApiUserService
    {
        ApiUser GetApiUser(int id);
        ApiUser SaveApiUser(ApiUser input);
        ApiUser DeleteApiUser(int id);
        ApiUser GetApiUserByApiKey(string apiKey);
    }
}
