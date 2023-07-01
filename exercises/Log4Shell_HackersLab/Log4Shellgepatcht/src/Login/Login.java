import java.util.Scanner;
import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;
import org.apache.logging.log4j.core.config.Configurator;
import org.apache.logging.log4j.core.config.builder.api.ConfigurationBuilder;
import org.apache.logging.log4j.core.config.builder.impl.BuiltConfiguration;
import org.apache.logging.log4j.core.config.builder.api.ConfigurationBuilderFactory;

public class Login {
    
    private static String[][] dictionary = {			//Simulation einer Datenbank
            {"Hans", "Hans1"},
            {"Peter", "Peter1"},
            {"Fabian", "Fabian1"},
            {"Klaus", "Klaus1"},
            {"Johanna", "Johanna1"},
            {"Sarah", "Sarah1"},
            {"Lisa", "Lisa1"},
            {"Kristina", "Kristina1"},
    };
    
    public static void main(String[] args) {

    	ConfigurationBuilder<BuiltConfiguration> builder = ConfigurationBuilderFactory.newConfigurationBuilder();	//Erstellung eines Log-Files, in der die Logs gespeichert werden
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
        
        Logger logger = LogManager.getLogger(Login.class);
        

    	Scanner sc = new Scanner(System.in);					//Scanner fuer Eingabe-Auslesung im Terminal
    	boolean isRunning = true;								//Programm laeuft, solange 'isRunning == true'
    	String username;
    	String password;
    	boolean correctInputLogout = false;						//Fuer korrektes Logout, nach der Anmeldung.
		            
    	System.out.println("Anwendung erfolgreich gestartet!\n");
    	
    	while(isRunning) {
    	
        System.out.println("Bitte gebe deinen Benutzernamen ein: ");            
		String input_username = sc.nextLine();					//Auslesung der Benutzereingabe fuer Benutzernamen
		correctInputLogout = false;
		
		
		
		
        username = check_username(input_username);				//Pruefen ob Username existiert
            	
            	if (username != null) {							//Wenn Username existiert...
            		
                    System.out.println("Bitte gebe dein Passwort ein: ");		//Benutzer auffordern Passwort einzugeben
                    String input_password = sc.nextLine();						//Auslesung der Benutzereingabe fuer Benutzernamen
                    
                    password = check_password(input_password);					//Pruefen ob Passwort existiert
                    
                    if (password != null) {										//Wenn Username korrekt...
                    	
                    	System.out.println("Anmeldung erfolgt!\n");
                    	
                    	
                    	while(!correctInputLogout) {							//Wartet solange, bis User durch korrekte Eingabe von '/logout' sich ausloggt
                    		
                    		System.out.println("Fuer Logout bitte '/logout' tippen ");
                        	String logout_user = sc.nextLine();
                    		
                    		if (logout_user.equalsIgnoreCase("/logout")) {		//Wenn 'logout_user' == '/logout' wird ausgeloggt
                            	
                            	System.out.println("User " + input_username + " hat sich ausgeloggt.\n");
                            	correctInputLogout = true;						//Variable auf true setzen, um aus while-Schleife zu kommen. Neuer Benutzer kann sich nun wieder anmelden
                            }
                    	}
                    	
                    }
                    else {
                    	
                    	System.out.println("Passwort falsch!");					
                        logger.error("Ein Nutzer hat das falsche Passwort eingegeben: '{}'", input_password);		//Wenn Passwort falsch eingegeben wurde, wird dies geloggt
                    	
                    }
                    
                    
                } else {
                	
                    System.out.println("Username existiert nicht!");
                    logger.error("Ein Nutzer hat versucht, sich mit einem nicht existierenden Benutzernamen einzuloggen: '{}'", input_username); 		//Wenn Username falsch eingegeben wurde oder nicht existiert, wird dies geloggt
                }
            
        
    	}
        sc.close();
    }
    
    public static String check_username(String word) {		//Methode um zu pruefen ob Username existiert
    	
        for (String[] entry : dictionary) {
        	
            if (entry[0].equalsIgnoreCase(word)) {
            	
                return entry[1];
                
            }
        }
        return null;
    }
    
    public static String check_password(String word) {
    	
        for (String[] entry : dictionary) {
        	
            if (entry[1].equalsIgnoreCase(word)) {
            	
                return entry[0];
                
            }
        }
        return null;
    }
    
}