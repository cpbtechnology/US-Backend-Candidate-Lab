using System;
using Microsoft.VisualStudio.TestTools.UnitTesting;

using Notesy.Core.Models;
using Notesy.Core.Services.Concrete;

namespace Notesy.Tests.Core.Services
{
    [TestClass]
    public class NoteServiceTests
    {
        private NoteService svc = new NoteService();

        [TestMethod]
        public void TestNoteInsert()
        {
            var n = new Note() { ApiUserId = 1, Description = "Go to Santa Monica Pier and watch Dr. Who", Title = string.Format("[{0}] Dr Who @ the beach.", DateTime.UtcNow.Ticks) };

            var result = svc.SaveNote(n);

            Assert.IsNotNull(result);
            Assert.IsTrue(result.Id != 0);
        }
    }
}
