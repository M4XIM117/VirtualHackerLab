import java.util.Scanner;
import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;
import org.apache.logging.log4j.core.config.Configurator;
import org.apache.logging.log4j.core.config.builder.api.ConfigurationBuilder;
import org.apache.logging.log4j.core.config.builder.impl.BuiltConfiguration;
import org.apache.logging.log4j.core.config.builder.api.ConfigurationBuilderFactory;

public class TranslatorApp {
    
    private static String[][] dictionary = {
            {"Hallo", "Hello"},
            {"Welt", "World"},
            {"Hund", "Dog"},
            {"Katze", "Cat"},
            {"Apfel", "Apple"},
            {"Banane", "Banana"},
            {"Tisch", "Table"},
            {"Stuhl", "Chair"},
    };
    
    public static void main(String[] args) {

    	ConfigurationBuilder<BuiltConfiguration> builder = ConfigurationBuilderFactory.newConfigurationBuilder();
        builder.setStatusLevel(org.apache.logging.log4j.Level.INFO);
        builder.setConfigurationName("MyLog4jConfiguration");

        builder.add(builder.newAppender("FileAppender", "File")
                .addAttribute("fileName", "logs/mylog.log")
                .addAttribute("append", false)
                .add(builder.newLayout("PatternLayout")
                        .addAttribute("pattern", "%d [%t] %-5level: %msg%n")));

        builder.add(builder.newRootLogger(org.apache.logging.log4j.Level.INFO)
                .add(builder.newAppenderRef("FileAppender")));

        Configurator.initialize(builder.build());
        
        Logger logger = LogManager.getLogger(TranslatorApp.class);
        

    	Scanner sc = new Scanner(System.in);
    	boolean isRunning = true;
		            
    	System.out.println("Uebersetzer erfolgreich gestartet!\n");
        System.out.println("Informationen fuer Dich:\n");
        System.out.println("Hier kannst Du deutsche Woerter ins englische uebersetzen.");
        System.out.println("Trage hierzu einfach das Wort ein, welches du uebersetzen moechtest.");
        System.out.println("Tippe 'exit' um das Programm zu beenden.\n");            
		        	
        while (isRunning) {
        	
        	System.out.println("Uebersetze: ");
        	String input = sc.nextLine();
        	
        	if (input.equalsIgnoreCase("exit")) {
        		
                isRunning = false;
                
            } else {
               
            	String translation = translate(input);
            	
            	if (translation != null) {
            		
                    System.out.println("Uebersetzung: " + translation);
                    
                } else {
                	
                    System.out.println("Das Wort konnte nicht uebersetzt werden. Wir arbeiten daran!");
                    logger.error("Ein Nutzer hat ein nicht existierendes Wort uebersetzt: '{}'", input);
                }
            }
        }
        
        sc.close();
    }
    
    public static String translate(String word) {
    	
        for (String[] entry : dictionary) {
        	
            if (entry[0].equalsIgnoreCase(word)) {
            	
                return entry[1];
                
            }
        }
        return null;
    }
    
}