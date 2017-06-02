import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import javax.xml.ws.spi.http.HttpContext;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.auth.AuthScope;
import org.apache.http.auth.Credentials;
import org.apache.http.auth.UsernamePasswordCredentials;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.CredentialsProvider;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.protocol.HttpClientContext;
import org.apache.http.impl.client.BasicCredentialsProvider;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.BasicHttpContext;
import org.apache.http.protocol.HTTP;
import org.apache.http.util.EntityUtils;
import org.json.JSONException;
import org.json.JSONObject;


public class sender {
	public static void main(String[] args) {
		HttpClient httpclient = new DefaultHttpClient();
	
		HttpClientContext context = HttpClientContext.create();
        HttpPost httppost = new HttpPost("http://api.login-sms.com/token");
        try {
            List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
            nameValuePairs.add(new BasicNameValuePair("client_id", "RJ6JhG1pzqZjmJn"));
            nameValuePairs.add(new BasicNameValuePair("client_secret", "GwmeB5IQJUM3ZTS"));
            nameValuePairs.add(new BasicNameValuePair("grant_type", "client_credentials"));
            nameValuePairs.add(new BasicNameValuePair("urlAccessToken", "http://api.login-sms.com/token"));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs, HTTP.UTF_8));
            httppost.addHeader("Authentication", "authorizationString");
            
            HttpResponse tokenResponse = httpclient.execute(httppost,context);
            System.out.println(tokenResponse.getStatusLine().getStatusCode());
            JSONObject json_auth = new JSONObject(EntityUtils.toString(tokenResponse.getEntity()));
            System.out.println("token" + json_auth);
            String token = json_auth.getString("token");
            System.out.println("token" + token);

        } catch (ClientProtocolException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } catch (JSONException e) {
        	
        }
	}
}
