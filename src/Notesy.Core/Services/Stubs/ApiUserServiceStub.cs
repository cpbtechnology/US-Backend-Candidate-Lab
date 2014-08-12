using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Notesy.Core.Models;
using Notesy.Core.Services.Interfaces;

namespace Notesy.Core.Services.Stubs
{
    public class ApiUserServiceStub : IApiUserService
    {
        private string API_KEY = "BEF0A331-C388-43D2-96A0-6B94838F87E0";
        private string API_SECRET = "01D25503-C5C4-46A3-B99A-8BE8BB2AF0D7";

        public ApiUser GetApiUser(int id)
        {
            return new ApiUser()
            {
                ApiKey = API_KEY,
                ApiSecret = API_SECRET,
                Id = id,
                Name = "Famous Dave"
            };
        }

        public ApiUser SaveApiUser(ApiUser input)
        {
            // if id = 0 (or null if you're using a nullable type) then this is new so insert, otherwise it's an update (aka an upsert)
            return input;
        }

        public ApiUser DeleteApiUser(int id)
        {
            return new ApiUser()
            {
                ApiKey = API_KEY,
                ApiSecret = API_SECRET,
                Id = id,
                Name = "Famous Dave"
            };
        }

        public ApiUser GetApiUserByApiKey(string apiKey)
        {
            throw new NotImplementedException();
        }
    }
}
