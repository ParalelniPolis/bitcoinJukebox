package jettySocket;

import java.util.concurrent.CountDownLatch;
import java.util.concurrent.Future;
import java.util.concurrent.TimeUnit;
import org.eclipse.jetty.websocket.api.Session;
import org.eclipse.jetty.websocket.api.StatusCode;
import org.eclipse.jetty.websocket.api.annotations.OnWebSocketClose;
import org.eclipse.jetty.websocket.api.annotations.OnWebSocketConnect;
import org.eclipse.jetty.websocket.api.annotations.OnWebSocketMessage;
import org.eclipse.jetty.websocket.api.annotations.WebSocket;
import org.eclipse.jetty.websocket.api.annotations.OnWebSocketError;

/**
 * Basic Echo Client Socket
 */
@WebSocket(maxTextMessageSize = Integer.MAX_VALUE)
public class SimpleEchoSocket {

    private final CountDownLatch closeLatch;

    @SuppressWarnings("unused")
    private Session session;

    public SimpleEchoSocket() {
        this.closeLatch = new CountDownLatch(5);
    }

    public boolean awaitClose(int duration, TimeUnit unit) throws InterruptedException {
        return this.closeLatch.await(duration, unit);
    }

    @OnWebSocketClose
    public void onClose(int statusCode, String reason) {
        System.out.printf("Connection closed: %d - %s%n", statusCode, reason);
        this.session = null;
        this.closeLatch.countDown();
    }

    @OnWebSocketConnect
    public void onConnect(Session session) {
        System.out.printf("Got connect: %s%n", session);
        this.session = session;
        try {
            Future<Void> fut;
            fut = session.getRemote().sendStringByFuture("{\"op\":\"unconfirmed_sub\"}");
//            fut = session.getRemote().sendStringByFuture("{\"op\":\"ping_block\"}");
//            fut = session.getRemote().sendStringByFuture("{\"op\":\"ping_tx\"}");
            fut.get(5, TimeUnit.SECONDS);
            session.close(StatusCode.NORMAL, "I'm done");
        } catch (Throwable t) {
            t.printStackTrace();
        }
    }

    @OnWebSocketMessage
    public void onMessage(String msg) {
        System.out.printf("Got msg: %s%n", msg);
    }

    @OnWebSocketError
    public void onError(Throwable error) {
        error.printStackTrace();
    }
}