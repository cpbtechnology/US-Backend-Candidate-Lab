using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Web;

namespace NotesApiWeb.Helpers
{
	public class BaseClient
	{
		protected readonly string _endpoint;

		private string _apiName;
		public string apiName
		{
			get { return _apiName; }
			set { _apiName = value; }
		}

		private string _apiKey;
		public string apiKey
		{
			get { return _apiKey; }
			set { _apiKey = value; }
		}

		public BaseClient(string baseUrl, string controller, string action)
		{
			_endpoint = String.Concat(baseUrl, "/", controller, "/", action);
		}

		public T Get<T>(int top = 0, int skip = 0)
		{
			using (HttpClient httpClient = NewHttpClient())
			{
				string endpoint = _endpoint + "?";
				List<string> parameters = new List<string>();
				if (top > 0) parameters.Add(string.Concat("$top=", top));
				if (skip > 0) parameters.Add(string.Concat("$skip=", skip));
				endpoint += string.Join("&", parameters);
				HttpResponseMessage response = httpClient.GetAsync(endpoint).Result;
				return JsonConvert.DeserializeObject<T>(response.Content.ReadAsStringAsync().Result);
			}
		}

		public T Get<T>(string id)
		{
			using (HttpClient httpClient = NewHttpClient())
			{
				HttpResponseMessage response = httpClient.GetAsync(String.Concat(_endpoint, "/", id)).Result;
				return JsonConvert.DeserializeObject<T>(response.Content.ReadAsStringAsync().Result);
			}
		}

		public T Get<T>(NameValueCollection parms)
		{
			using (HttpClient httpClient = NewHttpClient())
			{
				HttpResponseMessage response = httpClient.GetAsync(String.Concat(_endpoint, ToQueryString(parms))).Result;
				return JsonConvert.DeserializeObject<T>(response.Content.ReadAsStringAsync().Result);
			}
		}

		public bool Post<T>(T data)
		{
			using (HttpClient httpClient = NewHttpClient())
			{
				String obj = JsonConvert.SerializeObject(data);
				HttpRequestMessage requestMessage = new HttpRequestMessage();
				requestMessage.Method = HttpMethod.Post;
				requestMessage.Content = new StringContent(JsonConvert.SerializeObject(data), Encoding.UTF8, "application/json");
				HttpResponseMessage result = httpClient.PostAsync(_endpoint, requestMessage.Content).Result;
				return result.IsSuccessStatusCode;
			}
		}

		public string Put<T>(string id, T data)
		{
			using (HttpClient httpClient = NewHttpClient())
			{
				HttpRequestMessage requestMessage = new HttpRequestMessage();
				requestMessage.Method = HttpMethod.Put;
				requestMessage.Content = new StringContent(JsonConvert.SerializeObject(data), Encoding.UTF8, "application/json");
				HttpResponseMessage result = httpClient.PutAsync(String.Concat(_endpoint, "/", id), requestMessage.Content).Result;
				return result.Content.ReadAsStringAsync().Result;
			}
		}

		public string Delete(string id)
		{
			using (HttpClient httpClient = NewHttpClient())
			{
				HttpResponseMessage result = httpClient.DeleteAsync(String.Concat(_endpoint, "/", id)).Result;
				return result.Content.ToString();
			}
		}

		protected HttpClient NewHttpClient()
		{
			HttpClient newClient = new HttpClient();
			newClient.DefaultRequestHeaders.Authorization =
				new AuthenticationHeaderValue("Basic", System.Convert.ToBase64String(System.Text.UTF8Encoding.UTF8.GetBytes(string.Format("{0}:{1}", _apiName, _apiKey))));
			return newClient;
		}

		protected string ToQueryString(NameValueCollection nvc)
		{
			return "?" + string.Join("&", Array.ConvertAll(nvc.AllKeys, key => string.Format("{0}={1}", HttpUtility.UrlEncode(key), HttpUtility.UrlEncode(nvc[key]))));
		}

	}

}