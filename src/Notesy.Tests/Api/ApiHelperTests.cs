using System;
using Microsoft.VisualStudio.TestTools.UnitTesting;

using Notesy.Api.Controllers;  // helper in a controler... starting to get wonky
using Notesy.Core.Models;

namespace Notesy.Tests.Api
{
    [TestClass]
    public class ApiHelperTests
    {
        [TestMethod]
        public void TestDoSignaturesMatch()
        {
            int id = 1;
            string apikey = "BEF0A331-C388-43D2-96A0-6B94838F87E0";
            int? callId = 123;
            string apisecret = "01D25503-C5C4-46A3-B99A-8BE8BB2AF0D7";
            
            string inputs = string.Format("{0}{1}{2}{3}", id, apikey, callId, apisecret);
            string signature = ApiHelper.GetHash(inputs);
            var user = new ApiUser()
            {
                Id = id, 
                ApiKey = apikey, 
                ApiSecret = apisecret, 
                Name = "Does not matter"
            };

            var result = ApiHelper.DoSignaturesMatch(user, signature, id.ToString(), apikey, callId.ToString());
            
            Assert.IsTrue(result);
        }

        [TestMethod]
        public void TestGetHash()
        {
            int id = 1;
            string apikey = "BEF0A331-C388-43D2-96A0-6B94838F87E0";
            int? callId = 123;
            string apisecret = "01D25503-C5C4-46A3-B99A-8BE8BB2AF0D7";

            string inputs = string.Format("{0}{1}{2}{3}", id, apikey, callId, apisecret);
            string signature = ApiHelper.GetHash(inputs);

            Assert.IsNotNull(signature);
            Assert.AreEqual("9660A2B557FB0E3D8110C69F197944EBECCD8FFB", signature);
        }
    }
}
