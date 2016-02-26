package chatbot; /**
 * chatbot.ChatBot.java
 * http://www.programmingforliving.com/2013/08/jsr-356-java-api-for-websocket-client-api.html
 */

import java.net.URI;

/**
 * chatbot.ChatBot
 * @author Jiji_Sasidharan
 */
public class ChatBot {

    /**
     * main
     * @param args
     * @throws Exception
     */
    public static void main(String[] args) throws Exception {
        String destUri = "wss://ws.blockchain.info/inv";
//        String destUri = "ws://echo.websocket.org";
        final ChatClientEndpoint clientEndPoint = new ChatClientEndpoint(new URI(destUri));
        clientEndPoint.addMessageHandler(message -> System.out.println("Got " + message + "\n"));

        clientEndPoint.sendMessage("{\"op\":\"ping_block\"}");
        Thread.sleep(3000);
    }

}

 