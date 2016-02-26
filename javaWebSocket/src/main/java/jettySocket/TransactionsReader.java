package jettySocket;

import java.net.URI;
import java.util.concurrent.TimeUnit;

import org.eclipse.jetty.util.resource.Resource;
import org.eclipse.jetty.util.ssl.SslContextFactory;
import org.eclipse.jetty.websocket.client.ClientUpgradeRequest;
import org.eclipse.jetty.websocket.client.WebSocketClient;

/**
  * Example of a simple Echo Client from http://www.eclipse.org/jetty/documentation/current/jetty-websocket-client-api.html
  */
public class TransactionsReader {

    public static void main(String[] args) {
        String destUri = "wss://ws.blockchain.info/inv";
//        String destUri = "ws://echo.websocket.org";
        SslContextFactory ssl = new SslContextFactory();
        WebSocketClient client = new WebSocketClient(ssl);
        SimpleEchoSocket socket = new SimpleEchoSocket();
        while (true) {
            try {
                client.start();
                URI echoUri = new URI(destUri);
                ClientUpgradeRequest request = new ClientUpgradeRequest();
                client.connect(socket, echoUri, request);
                System.out.printf("Connecting to : %s%n", echoUri);
                socket.awaitClose(5, TimeUnit.SECONDS);
            } catch (Throwable t) {
                t.printStackTrace();
            } finally {
                try {
                    client.stop();
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }

    }
}