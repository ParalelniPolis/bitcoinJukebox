package chatbot; /**
 * chatbot.ChatClientEndpoint.java
 * http://programmingforliving.com
 */

import org.glassfish.grizzly.ssl.SSLContextConfigurator;
import org.glassfish.grizzly.ssl.SSLEngineConfigurator;
import org.glassfish.tyrus.client.ClientManager;
import org.glassfish.tyrus.container.grizzly.GrizzlyEngine;

import java.net.URI;
import javax.websocket.*;

/**
 * ChatServer Client
 *
 * @author Jiji_Sasidharan
 */
@ClientEndpoint
public class ChatClientEndpoint {
    Session userSession = null;
    private MessageHandler messageHandler;

    public ChatClientEndpoint(URI endpointURI) {
        final ClientManager client = ClientManager.createClient();

        System.getProperties().put("javax.net.debug", "all");
        System.getProperties().put(SSLContextConfigurator.KEY_STORE_FILE, "...");
        System.getProperties().put(SSLContextConfigurator.TRUST_STORE_FILE, "...");
        System.getProperties().put(SSLContextConfigurator.KEY_STORE_PASSWORD, "...");
        System.getProperties().put(SSLContextConfigurator.TRUST_STORE_PASSWORD, "...");
        final SSLContextConfigurator defaultConfig = new SSLContextConfigurator();

        defaultConfig.retrieve(System.getProperties());
        // or setup SSLContextConfigurator using its API.

        SSLEngineConfigurator sslEngineConfigurator =
                new SSLEngineConfigurator(defaultConfig, true, false, false);
        client.getProperties().put(GrizzlyEngine.SSL_ENGINE_CONFIGURATOR,
                sslEngineConfigurator);
        try {
            client.connectToServer(this , ClientEndpointConfig.Builder.create().build(),
                endpointURI);
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    /**
     * Callback hook for Connection open events.
     *
     * @param userSession
     *            the userSession which is opened.
     */
    @OnOpen
    public void onOpen(Session userSession) {
        this.userSession = userSession;
        System.out.println("opened");
    }

    /**
     * Callback hook for Connection close events.
     *
     * @param userSession
     *            the userSession which is getting closed.
     * @param reason
     *            the reason for connection close
     */
    @OnClose
    public void onClose(Session userSession, CloseReason reason) {
        this.userSession = null;
    }

    /**
     * Callback hook for Message Events. This method will be invoked when a
     * client send a message.
     *
     * @param message
     *            The text message
     */
    @OnMessage
    public void onMessage(String message) {
        System.out.println("got message");
        if (this.messageHandler != null)
            this.messageHandler.handleMessage(message);
    }

    /**
     * register message handler
     *
     * @param message
     */
    public void addMessageHandler(MessageHandler msgHandler) {
        this.messageHandler = msgHandler;
    }

    /**
     * Send a message.
     *
     * @param user
     * @param message
     */
    public void sendMessage(String message) {
        this.userSession.getAsyncRemote().sendText(message);
    }

}


