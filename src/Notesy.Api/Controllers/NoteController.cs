using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

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
        // Note: This will be at something like: http://localhost:63185/note/save
        public ActionResult Save()
        {
            // TODO: real service call type things
            return Json(new { success = true }, JsonRequestBehavior.AllowGet);
        }

        private bool ValidateAuth()
        {
            // TODO: actual auth stuff
            return true;
        }
    }
}