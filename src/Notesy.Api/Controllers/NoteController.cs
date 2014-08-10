using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Web;
using System.Web.Mvc;

using Notesy.Core.Models;
using Notesy.Core.Services.Interfaces;

namespace Notesy.Api.Controllers
{
    // So, there are a quite a few ways to setup an API.  For this one, since it's a quick-hitter, I'm just going to leverage a bunch of stuff
    // that's already baked in so we can whip this thing out.

    // For now, calls will come into the NoteController which will be where the authentication goes down.  If a call passes auth, then we will
    // send the call off to the dependency injected Note Service (which could be a real service or a fake/stub one).  This provides us with a 
    // host of advantages such as being able to isolate auth to the very edge (aka application boundry) and we can then re-use all that delicious
    // code we've written in the service that does, you know, actual work.  We could  then do things like re-use the API internally without auth 
    // on something akin to a private API or even call it from inside that Notesy.Web project (which could be a brochure site, a web app, etc).

    // Additionally, auth can be done in many ways.  We could do OAuth if we were leveraging an external service (e.g. we had folks sign up for
    // API access with Twitter).  I'm going to do my patented "fake auth" which will illustrate a "signed" API similar to this real world
    // example: http://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-creating-signed-url-canned-policy.html
    // I'm going to do this inline to save time but if this were a real life app I'd look into using an Action Filter or possibly an 
    // existing library off nuget.  Or a base controller.  Or an extension method.  Or a helper.  Or a combination of these.

    // TLDR; Everything always depends.  Real world constraints might change how you architect things.

    public class NoteController : Controller
    {
        private readonly INoteService noteService;
        private readonly IApiUserService apiUserService;

        public NoteController(INoteService noteService, IApiUserService apiUserService)
        {
            this.noteService = noteService;
            this.apiUserService = apiUserService;
        }

        // Note: This will be at something like: http://localhost:63185/note/save
        // TODO: since this is taking in a note model we'll need to make sure we're serializing the input properly before it hits the api

        /// <summary>
        /// Save a Note.
        /// </summary>
        /// <param name="input">The note to save.</param>
        /// <param name="apikey">The api key of the user request.</param>
        /// <param name="callId">A rotating integer to uniquely identify this request.  Usually just use current ticks count.  There are a number of ways to do this.</param>
        /// <param name="signature">Signature for this api request.</param>
        /// <returns></returns>
        public ActionResult Save(Note input, string apikey = null, int? callId = null, string signature = null)
        {
            if (!ApiHelper.ValidateAuth(ApiHelper.ToJsonString(input), apikey, signature)) { return new HttpUnauthorizedResult(); }

            var result = noteService.SaveNote(input);

            return Json(input, JsonRequestBehavior.AllowGet);
        }

        public ActionResult Get(int id, string apikey = null, int? callId = null, string signature = null)
        {
            // basic logic for this architecture (could be different)
            // 1) validate the auth on the incoming request
            // 2) next we need to get the api user by apikey (oops - we need to write that!)
            // 3) next we need to get the note
            // 4) last we need to check that the api user is the owner of this note

            // obviously lots of decisions here... this might have been easier if we used
            // an orm.  we also could have pushed this logic one level lower so we could
            // reuse it.  this will be good for now though.

            if (!ApiHelper.ValidateAuth(id.ToString(), apikey, callId.Value.ToString(), signature)) { return new HttpUnauthorizedResult(); }

            var user = apiUserService.GetApiUserByApiKey(apikey);
            var note = noteService.GetNote(id);

            if (user.Id == note.ApiUserId)
            {
                return Json(note, JsonRequestBehavior.AllowGet);
            }

            // TODO: Have to think about what to do with errors.
            return Json(note, JsonRequestBehavior.AllowGet);
        }

        public ActionResult Delete(int id, string apikey = null, int? callId = null, string signature = null)
        {
            if (!ApiHelper.ValidateAuth(id.ToString(), apikey, callId.Value.ToString(), signature)) { return new HttpUnauthorizedResult(); }

            var result = noteService.DeleteNote(id);

            return Json(result, JsonRequestBehavior.AllowGet);
        }
    }

    public static class ApiHelper
    {
        // TODO: the following methods would be good candidates for relocation to a helper or other logical place.
        // NOTE: Need to start making these public now for testing.  It would be better to put this is in it's own
        // helper class or something but we're running low on time (for now at least).

        public static bool ValidateAuth(string apiKey, string signatureToCheck, params string[] args)
        {
            // TODO: actual auth stuff
            // 1) lookup api user
            // 2) generate signature of inputs
            // 3) compare generated signature to incoming signature
            // 4) if valid, return true, otherwise false - note there could be a number of other things to check here: api usage, incoming IP, etc.

            return true;
        }

        /// <summary>
        /// 
        /// </summary>
        /// <param name="signature"></param>
        /// <param name="args"></param>
        /// <returns></returns>
        public static bool DoSignaturesMatch(ApiUser apiUser, string signature, params string[] args)
        {
            // how to generate a signature:
            // 1) concat all the call parameters into one string (see string array above)
            // 2) run some agreed upon encryption algorithm on concat string using the shared secret associated with the apikey => apiuser for this request
            
            // IMPORTANT: for this to actually work correctly we need to store the call id so that api calls cannot be replayed
            // NOTE: remember this is just sort of a quick homebrew system.  you'd almost certainly want to reuse an appropriate auth library.
            // TODO: i think i got that right, double-check once implemented and document any changes here

            var sb = new StringBuilder();
            foreach (var arg in args)
            {
                sb.Append(arg);
            }
            sb.Append(apiUser.ApiSecret);
            var gen = ApiHelper.GetHash(sb.ToString());

            return gen == signature;
        }

        public static string ToJsonString(object input)
        {
            // here is where we'd serialize the object out to a string containing a json object
            return "";
        }

        private static HashAlgorithm HashProvider = new SHA1Managed();

        public static string GetHash(string input)
        {
            byte[] inputBytes = Encoding.UTF8.GetBytes(input);
            byte[] data = HashProvider.ComputeHash(inputBytes);
            var output = ByteArrayToHex(data);

            return output;
        }

        // http://stackoverflow.com/questions/311165/how-do-you-convert-byte-array-to-hexadecimal-string-and-vice-versa
        public static string ByteArrayToHex(byte[] barray)
        {
            char[] c = new char[barray.Length * 2];
            byte b;
            for (int i = 0; i < barray.Length; ++i)
            {
                b = ((byte)(barray[i] >> 4));
                c[i * 2] = (char)(b > 9 ? b + 0x37 : b + 0x30);
                b = ((byte)(barray[i] & 0xF));
                c[i * 2 + 1] = (char)(b > 9 ? b + 0x37 : b + 0x30);
            }

            return new string(c);
        }
    }
}