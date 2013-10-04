using NotesApi.Models;
using NotesApiWeb.Filters;
using NotesApiWeb.Helpers;
using System;
using System.Collections.Generic;
using System.Web.Mvc;
using WebMatrix.WebData;

namespace NotesApiWeb.Controllers
{
	[Authorize]
	[InitializeSimpleMembership]
	public class HomeController : Controller
	{

		public ActionResult Index()
		{
			ViewBag.Message = "Keep your thoughts organized";
			return View();
		}

		public ActionResult NotesList(int page)
		{
			List<note> model = NotesApiContext.GetNotesByUId(WebSecurity.CurrentUserId.ToString());
			return PartialView(model);
		}

		public ActionResult AddNote()
		{
			note model = new note
			{
				userToken = WebSecurity.CurrentUserId.ToString(),
				lastModified = DateTime.Now
			};
			return PartialView(model);
		}

		[HttpPost]
		public ActionResult AddNote(note model)
		{
			bool result = NotesApiContext.Create<note>(model);
			if (result == true)
			{
				return Json(new { success = true });
			}
			else
			{
				return Json(new { success = false });
			}
		}

		public ActionResult EditNote(int id)
		{
			note model = NotesApiContext.Get<note>(id.ToString());
			return PartialView(model);
		}

		[HttpPost]
		public ActionResult EditNote(note model)
		{
			bool result = NotesApiContext.Update<note>(model.noteId.ToString(), model);
			if (result == true)
			{
				return Json(new { success = true });
			}
			else
			{
				return Json(new { success = false });
			}
		}

		public ActionResult DeleteNote(int id)
		{
			NotesApiContext.Delete<note>(id.ToString());
			return RedirectToAction("Index");
		}

	}
}
