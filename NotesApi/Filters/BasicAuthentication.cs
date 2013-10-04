
using NotesApi.Models;
using System;
using System.Linq;
using System.Text;
namespace BusinessLMS.ActionFilters
{
	public class BasicAuthentication : System.Web.Http.Filters.ActionFilterAttribute
	{
		public override void OnActionExecuting(System.Web.Http.Controllers.HttpActionContext actionContext)
		{
			//base.OnActionExecuting(actionContext); // UN-COMMENT FOR API TESTING WITHOUT WEBSITE
			/* COMMENT FOR API TESTING WITHOUT WEBSITE, !!! WARNING THIS DISABLES API SECURITY !!! */

			NotesApiDBContext db = new NotesApiDBContext();

			if (actionContext.Request.Headers.Authorization == null)
			{
				actionContext.Response = new System.Net.Http.HttpResponseMessage(System.Net.HttpStatusCode.Unauthorized);
			}
			else
			{
				var authToken = actionContext.Request.Headers.Authorization.Parameter;
				var decodedToken = Encoding.UTF8.GetString(Convert.FromBase64String(authToken));
				var apiName = int.Parse(decodedToken.Substring(0, decodedToken.IndexOf(":")));
				var apiKey = decodedToken.Substring(decodedToken.IndexOf(":") + 1);
				UserProfile user = (from u in db.UserProfiles
									join p in db.webpages_Membership on u.UserId equals p.UserId
									where u.UserId == apiName && p.Password == apiKey
									select u).FirstOrDefault();
				if (user != null)
				{
					base.OnActionExecuting(actionContext);
				}
				else
				{
					actionContext.Response = new System.Net.Http.HttpResponseMessage(System.Net.HttpStatusCode.Unauthorized);
				}
			}

		}
	}
}