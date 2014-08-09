using System;
using System.Collections.Generic;
using System.Linq;
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

        public NoteController(INoteService noteService)
        {
            this.noteService = noteService;
        }

        // Note: This will be at something like: http://localhost:63185/note/save
        // TODO: since this is taking in a note model we'll need to make sure we're serializing the input properly before it hits the api

        /// <summary>
        /// Save a Note.
        /// </summary>
        /// <param name="input"></param>
        /// <param name="apikey"></param>
        /// <param name="signature"></param>
        /// <param name="callId"></param>
        /// <returns></returns>
        public ActionResult Save(Note input, string apikey = null, int? callId = null, string signature = null)
        {
            if (!ValidateAuth(ToJsonString(input), apikey, signature)) { return new HttpNotFoundResult(); }

            var result = noteService.SaveNote(input);

            return Json(input, JsonRequestBehavior.AllowGet);
        }

        public ActionResult Get(int id)
        {
            // TODO: add auth stuff
            var result = noteService.GetNote(id);

            return Json(result, JsonRequestBehavior.AllowGet);
        }

        public ActionResult Delete(int id)
        {
            // TODO: add auth stuff
            var result = noteService.DeleteNote(id);

            return Json(result, JsonRequestBehavior.AllowGet);
        }


        private static bool ValidateAuth(string signatureToCheck, params string[] args)
        {
            // TODO: actual auth stuff
            // 1) lookup api user
            // 2) generate signature of inputs
            // 3) compare generated signature to incomming signatue
            // 4) if valid, return true, otherwise false - note there could be a number of other things to check here: api usage, incoming IP, etc.

            return true;
        }

        private static string ToJsonString(object input)
        {
            // here is where we'd serialize to the object out to a string containing a json object
            return "";
        }
    }
}