using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;
using Newtonsoft.Json.Linq;

namespace Api_login_sms {
    class Program {
        private const string url = "http://api.login-sms.com";
        private const string key = "RJ6JhG1pzqZjmJn"; // credencial enviada 
        private const string secret = "GwmeB5IQJUM3ZTS"; // credencial enviada
        
        static void Main(string[] args) {
            RunAsync().Wait();
        }

        public static async Task RunAsync() {
            HttpClient client = new HttpClient();
            client.BaseAddress = new Uri(url);

            var content = new FormUrlEncodedContent(new[]
            {
                new KeyValuePair<string, string>("client_id", key),
                new KeyValuePair<string, string>("client_secret", secret),
                new KeyValuePair<string, string>("grant_type", "client_credentials")

            });
            var request = new HttpRequestMessage(HttpMethod.Post, "/token");
            request.Content = content;
            
            HttpResponseMessage response = await client.SendAsync(request);

            string access_token = "";

            if (response.IsSuccessStatusCode) {
                String o = await response.Content.ReadAsStringAsync();

                JObject json = JObject.Parse(o);

                Console.WriteLine(json["access_token"]);
                access_token = json["access_token"].ToString();
            }

            client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", access_token);

            JObject message = new JObject();
            message["to_number"] = "+5492804324498";
            message["content"] = "hola";

            //Envio simple -- send simple

            response = await client.PostAsJsonAsync("/messages/send", message);
            if (response.IsSuccessStatusCode) {
                Console.WriteLine("mensaje enviodo");
                Console.ReadKey();
            }


            //Envio masivo -- send batch

            JObject messageBatch = new JObject();
            message["to_number"] = "+592804324498";
            message["contact_group_id"] = 1;

            response = await client.PostAsJsonAsync("/messages/send-batch", message);
            if (response.IsSuccessStatusCode) {
                Console.WriteLine("mensaje enviodo");
                Console.ReadKey();
            }


            //Envios diarios - today shipped
            response = await client.GetAsync("/messages/shipped-today");
            if (response.IsSuccessStatusCode) {

                //list of messsege (string)
                String messages = await response.Content.ReadAsStringAsync();
              
            }

        }
       
    }
}
