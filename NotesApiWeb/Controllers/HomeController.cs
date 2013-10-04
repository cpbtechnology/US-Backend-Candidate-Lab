using NotesApi.Models;
using System.Collections.Generic;
using System.Web.Mvc;

namespace NotesApiWeb.Controllers
{
	[Authorize]
	public class HomeController : Controller
	{
		public ActionResult Index()
		{
			ViewBag.Message = "Keep your thoughts organized";
			return View();
		}

		public ActionResult NotesList(int page)
		{
			List<note> model = new List<note>();
			return PartialView(model);
		}

	}
}
