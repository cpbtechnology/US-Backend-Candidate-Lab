using NotesApi.Models;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using WebMatrix.WebData;

namespace NotesApiWeb.Helpers
{
	public static class NotesApiContext
	{
		public static string baseApiUrl
		{
			get { return ConfigurationManager.AppSettings["ApiUrl"]; }
		}

		private static NotesApiDBContext db = new NotesApiDBContext();

		#region Generic Methods

		public static T Get<T>(string id)
		{
			BaseClient client = new BaseClient(baseApiUrl, string.Concat(typeof(T).Name, "s"), string.Concat("Get", typeof(T).Name));
			client.apiName = WebSecurity.CurrentUserId.ToString();
			client.apiKey = db.webpages_Membership.Where(w => w.UserId == WebSecurity.CurrentUserId).FirstOrDefault().Password;
			return client.Get<T>(id);
		}

		public static bool Create<T>(T model)
		{
			BaseClient client = new BaseClient(baseApiUrl, string.Concat(typeof(T).Name, "s"), string.Concat("Post", typeof(T).Name));
			client.apiName = WebSecurity.CurrentUserId.ToString();
			client.apiKey = db.webpages_Membership.Where(w => w.UserId == WebSecurity.CurrentUserId).FirstOrDefault().Password;
			return client.Post<T>(model);
		}

		public static bool Update<T>(string id, T model)
		{
			BaseClient client = new BaseClient(baseApiUrl, string.Concat(typeof(T).Name, "s"), string.Concat("Put", typeof(T).Name));
			client.apiName = WebSecurity.CurrentUserId.ToString();
			client.apiKey = db.webpages_Membership.Where(w => w.UserId == WebSecurity.CurrentUserId).FirstOrDefault().Password;
			return client.Put<T>(id.ToString(), model);
		}

		public static string Delete<T>(string id)
		{
			BaseClient client = new BaseClient(baseApiUrl, string.Concat(typeof(T).Name, "s"), string.Concat("Delete", typeof(T).Name));
			client.apiName = WebSecurity.CurrentUserId.ToString();
			client.apiKey = db.webpages_Membership.Where(w => w.UserId == WebSecurity.CurrentUserId).FirstOrDefault().Password;
			return client.Delete(id);
		}

		public static List<note> GetNotesByUId(string id)
		{
			BaseClient client = new BaseClient(baseApiUrl, "Notes", "GetNotes");
			client.apiName = WebSecurity.CurrentUserId.ToString();
			client.apiKey = db.webpages_Membership.Where(w => w.UserId == WebSecurity.CurrentUserId).FirstOrDefault().Password;
			return client.Get<List<note>>(id);
		}

		#endregion Generic Methods



	}
}