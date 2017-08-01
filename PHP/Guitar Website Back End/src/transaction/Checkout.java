package transaction;



import java.io.*;
import java.util.*;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class Checkout extends HttpServlet{
	
	private static final long serialVersionUID = 1L;
	
	String FirstName, LastName, Address, Postcode, EmailAddress;
	ArrayList<TxtItem> items;

	  
	  public void doGet(HttpServletRequest request,
	                    HttpServletResponse response)
	            throws ServletException, IOException
	  {
	     
		  FirstName = request.getParameter("first_name");
		  LastName = request.getParameter("last_name");
		  Address= request.getParameter("address");
		  Postcode = request.getParameter("postcode");
		  EmailAddress = request.getParameter("email_address");
		  
		  
	      response.setContentType("text/html");

	      PrintWriter out = response.getWriter();
		  String title = "Purchase Successful!";
	      String docType =
	      "<!doctype html public \"-//w3c//dtd html 4.0 " +
	      "transitional//en\">\n";
	      out.println(docType +
	                "<html>\n" +
	                "<head><title>" + title + "</title></head>\n" +
	                "<body bgcolor=\"#f0f0f0\">\n" +
	                "<h1 align=\"center\">" + title + "</h1>\n" +
	                "<ul>\n" +
	                "  <li><b>First Name</b>: "
	                + FirstName + "\n" +
	                "  <li><b>Last Name</b>: "
	                + LastName + "\n" +
	                "  <li><b>Address</b>: "
	                + Address + "\n" +
	                "  <li><b>Postcode</b>: "
	                + Postcode + "\n" +
	                "  <li><b>Email Address</b>: "
	                + EmailAddress + "\n" +
	                "</ul>\n" +
	                "</body></html>");
	  }

	  public void doPost(HttpServletRequest request,
	                     HttpServletResponse response)
	      throws ServletException, IOException {
	     doGet(request, response);
	  }
	
	
	public String returnHtml(){
    	String docType =
    			"<!doctype html public \"-//w3c//dtd html 4.0 " +
    					"transitional//en\">\n";

		return docType + "<html>\n<body><p>First Name: "+
				FirstName+
				"</br>Last Name: " + LastName+
				"</br>Address: " + Address+
				"</br>Postcode: " + Postcode+
				"</br>Email Address: " + Postcode+
				"</p></body>\n</html>";
	}
	public void writeToLog(String filePath){
		try{
			Date time = new Date();
			PrintWriter output = new PrintWriter(new BufferedWriter(new FileWriter(filePath, true)));
			output.println(FirstName + "," +
			LastName + "," +
			Address + "," +
			Postcode + "," +
			EmailAddress + "\n");
			output.close();
			System.out.println("LOG WRITE " + filePath + " - " + time.toString());
		}
		catch(IOException e){
			System.out.println(e.getMessage());
		}
	}
	public void writeToSO(){
		Date time = new Date();
		System.out.println(FirstName + "," +
		LastName + "," +
		Address + "," +
		Postcode + "," +
		EmailAddress + " - " + time.toString());
	}
}