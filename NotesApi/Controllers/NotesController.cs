using BusinessLMS.ActionFilters;
using NotesApi.Models;
using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity.Infrastructure;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;

namespace NotesApi.Controllers
{
	[BasicAuthentication]
	public class NotesController : ApiController
	{
		private NotesApiDBContext db = new NotesApiDBContext();

		// GET api/Notes
		public IEnumerable<note> Getnotes()
		{
			return db.notes.AsEnumerable();
		}

		// GET api/Notes/5
		public IEnumerable<note> GetNotes(string id)
		{
			return db.notes.Where(n => n.userToken == id).AsEnumerable();
		}

		// GET api/Notes/5
		public note Getnote(int id)
		{
			note note = db.notes.Find(id);
			if (note == null)
			{
				throw new HttpResponseException(Request.CreateResponse(HttpStatusCode.NotFound));
			}

			return note;
		}

		// PUT api/Notes/5
		public HttpResponseMessage Putnote(int id, note note)
		{
			if (!ModelState.IsValid)
			{
				return Request.CreateErrorResponse(HttpStatusCode.BadRequest, ModelState);
			}

			if (id != note.noteId)
			{
				return Request.CreateResponse(HttpStatusCode.BadRequest);
			}

			db.Entry(note).State = EntityState.Modified;

			try
			{
				db.SaveChanges();
			}
			catch (DbUpdateConcurrencyException ex)
			{
				return Request.CreateErrorResponse(HttpStatusCode.NotFound, ex);
			}

			return Request.CreateResponse(HttpStatusCode.OK);
		}

		// POST api/Notes
		public HttpResponseMessage Postnote(note note)
		{
			if (ModelState.IsValid)
			{
				db.notes.Add(note);
				db.SaveChanges();

				HttpResponseMessage response = Request.CreateResponse(HttpStatusCode.Created, note);
				response.Headers.Location = new Uri(Url.Link("DefaultApi", new { id = note.noteId }));
				return response;
			}
			else
			{
				return Request.CreateErrorResponse(HttpStatusCode.BadRequest, ModelState);
			}
		}

		// DELETE api/Notes/5
		public HttpResponseMessage Deletenote(int id)
		{
			note note = db.notes.Find(id);
			if (note == null)
			{
				return Request.CreateResponse(HttpStatusCode.NotFound);
			}

			db.notes.Remove(note);

			try
			{
				db.SaveChanges();
			}
			catch (DbUpdateConcurrencyException ex)
			{
				return Request.CreateErrorResponse(HttpStatusCode.NotFound, ex);
			}

			return Request.CreateResponse(HttpStatusCode.OK, note);
		}

		protected override void Dispose(bool disposing)
		{
			db.Dispose();
			base.Dispose(disposing);
		}
	}
}