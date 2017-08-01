package flightItinerary;

import java.util.ArrayList;
import java.util.Scanner;

import org.jgrapht.GraphPath;
import org.jgrapht.alg.DijkstraShortestPath;
import org.jgrapht.graph.SimpleDirectedWeightedGraph;

public class flightItenerary{   
	public static void main(String args[]) {
		
		SimpleDirectedWeightedGraph<String, ExtendedEdge>g = new SimpleDirectedWeightedGraph<String, ExtendedEdge>(ExtendedEdge.class);
        
//		*******************************************************
//		* Part A : Representing Direct Flights
//		*******************************************************
		
		//    ARRAY INDEX = 	 [0]		[1]			[2]		  [3]		[4]		  [5]		 [6]	    [7]		   [8]		   [9]
        
        String[] airports = {"Edinburgh","Heathrow","Amsterdam","Boston","Chicago","Montreal","Toronto","New Delhi","Shanghai","Hong Kong"};
        
    	String v1 = airports[0];
        String v2 = airports[1];
        String v3 = airports[2];
        String v4 = airports[3];
        String v5 = airports[4];
        String v6 = airports[5];
        String v7 = airports[6];
        String v8 = airports[7];
        String v9 = airports[8];
        String v10 = airports[9];

        g.addVertex(v1);
        g.addVertex(v2);
        g.addVertex(v3);
        g.addVertex(v4);
        g.addVertex(v5);
        g.addVertex(v6);
        g.addVertex(v7);
        g.addVertex(v8);
        g.addVertex(v9);
        g.addVertex(v10);
    	       
        
        ExtendedEdge    
        f = new ExtendedEdge(v1, v2, "EA115", 1130, 1230);	// Edinburgh to Heathrow
        g.addEdge(v1, v2, f);
        g.setEdgeWeight(f, 110);
        
    	f = new ExtendedEdge(v2, v1, "HA101", 1730, 1830);	// Heathrow to Edinburgh
    	g.addEdge(v2, v1, f);
    	g.setEdgeWeight(f, 110);
        
    	f = new ExtendedEdge(v2, v3, "HA343", 2340, 240);	// Heathrow to Amsterdam
    	g.addEdge(v2, v3, f);
    	g.setEdgeWeight(f, 100);
    	
       	f = new ExtendedEdge(v3, v2, "AA420", 1945, 2245);	// Amsterdam to Heathrow
       	g.addEdge(v3, v2, f);
    	g.setEdgeWeight(f, 100);
    	
    	f = new ExtendedEdge(v2, v4, "HA777", 1100, 1930);	// Heathrow to Boston
       	g.addEdge(v2, v4, f);
    	g.setEdgeWeight(f, 230);
    	
    	f = new ExtendedEdge(v4, v2, "BA123", 1410, 2240);	// Boston to Heathrow
       	g.addEdge(v4, v2, f);
    	g.setEdgeWeight(f, 230);
    	
    	f = new ExtendedEdge(v4, v5, "BA631", 1540 , 1740);	// Boston to Chicago
       	g.addEdge(v4, v5, f);
    	g.setEdgeWeight(f, 150);
    	
    	f = new ExtendedEdge(v5, v4, "CA699", 1200, 1400);	// Chicago to Boston
       	g.addEdge(v5, v4, f);
    	g.setEdgeWeight(f, 150);
    	
    	f = new ExtendedEdge(v4, v6, "BA626", 1900, 2010);	// Boston to Montreal
       	g.addEdge(v4, v6, f);
    	g.setEdgeWeight(f, 100);
    	
    	f = new ExtendedEdge(v6, v4, "MA554", 2200, 1110);	// Montreal to Boston
       	g.addEdge(v6, v4, f);
    	g.setEdgeWeight(f, 100);
    	
    	f = new ExtendedEdge(v6, v7, "MA832", 1720, 1830);	// Montreal to Toronto
       	g.addEdge(v6, v7, f);
    	g.setEdgeWeight(f, 90);
    	
    	f = new ExtendedEdge(v7, v6, "TA774", 1940, 2050);	// Toronto to Montreal
       	g.addEdge(v7, v6, f);
    	g.setEdgeWeight(f, 90);
    	
    	f = new ExtendedEdge(v1, v5, "EA666", 0600, 1700);	// Edinburgh to Chicago
       	g.addEdge(v1, v5, f);
    	g.setEdgeWeight(f, 560);
    	
    	f = new ExtendedEdge(v5, v1, "CA101", 700, 1800);	// Chicago to Edinburgh
       	g.addEdge(v1, v5, f);
    	g.setEdgeWeight(f, 560);
    	
    	f = new ExtendedEdge(v8, v9, "ND919", 1400, 1850);	// New Delhi to Shanghai
       	g.addEdge(v8, v9, f);
    	g.setEdgeWeight(f, 430);
    	
    	f = new ExtendedEdge(v9, v8, "SA616", 1030, 1520);	// Shanghai to New Delhi
       	g.addEdge(v8, v9, f);
    	g.setEdgeWeight(f, 430);
    	
    	f = new ExtendedEdge(v9, v10, "SA888", 1800, 2000);	// Shanghai to Hong Kong
       	g.addEdge(v9, v10, f);
    	g.setEdgeWeight(f, 230);
    	
    	f = new ExtendedEdge(v10, v9, "HK000", 1150, 1350);	// Hong Kong to Shanghai
       	g.addEdge(v10, v9, f);
    	g.setEdgeWeight(f, 230);	
			         
//		*******************************************************
//		* Part B : Least Cost Connections
//		*******************************************************
    	
     	Scanner s = new Scanner(System.in);

    	System.out.println("Type departing airport:");
		String departureAirport = s.nextLine();
		
		while(!checkExists(airports, departureAirport)){		// while the airport doesn't exist
			System.err.println("Airport does not exist, please try again");
			departureAirport = s.nextLine();					// re-prompt for input
		}
			
        System.out.println("Type destination airport:");
		String destinationAirport = s.nextLine();
		
		while(!checkExists(airports, destinationAirport)){		// while the airport doesn't exist
			System.err.println("Airport does not exist, please try again");
			destinationAirport = s.nextLine();					// re-prompt for input
			
			if (destinationAirport.equals(departureAirport)) {		// if both the airports are the same
				System.err.println("Departing from this airport, please try again");
				destinationAirport = s.nextLine();					// re-prompt for input
			}
		}
		
    	s.close();
    	
    	// find the shortest route between the airports
    	
		DijkstraShortestPath<String, ExtendedEdge> pathFinder = new DijkstraShortestPath<String, ExtendedEdge>(g, departureAirport, destinationAirport);
		GraphPath<String, ExtendedEdge> cheapestPath = pathFinder.getPath();
		
//		*******************************************************
//		* Part D : Itinerary
//		*******************************************************
		
        System.out.println("Itinerary for " + departureAirport + " to " + destinationAirport);

        System.out.println("Leg	Leave		At	On	Arrive		At");
        
        // for each step of the path print the flight information
        
        int i = 0;
        for (ExtendedEdge e:cheapestPath.getEdgeList()) {
        	i++; 
        	System.out.println(i+"	"+e.getAirport1()+"   	"+    	String.format("%04d", e.getDepartureTime()) +"	"+e.getFlightNumber()+"	"+e.getAirport2()+"   	"+String.format("%04d", e.getArrivalTime()));
        }

        // Calculate total cost by adding the weights
        
		double cost = cheapestPath.getWeight();
        System.out.println("Cost of journey: £" + cost);
        
//		*******************************************************
//		* Part E : Itinerary Duration
//		*******************************************************
        		
		int hours = 0;
		int mins = 0;
		ArrayList<Integer> timelist = new ArrayList<Integer>();
		
		// Calculate the total air time by finding the sum of the differences in departure time and arrival time for each step

        for (ExtendedEdge e : cheapestPath.getEdgeList()) {
        	hours = hours + findHours(e.getDepartureTime(), e.getArrivalTime());
        	mins = mins + findMinutes(e.getDepartureTime(), e.getArrivalTime());
        }
        
        System.out.println("Air time: "+ hours + " hours and " + mins + " minutes");
        
//		*******************************************************
//		* Part F : Alternative Extensions
//		*******************************************************
        
        // Calculate the total journey time
        
		hours = 0;
	    mins = 0;
	    
        for (ExtendedEdge e : cheapestPath.getEdgeList()) {
        	timelist.add(e.getDepartureTime());
        	timelist.add(e.getArrivalTime());
        }
        for (i=1; i<timelist.size(); i++) {
        	hours = hours + findHours(timelist.get(i-1), timelist.get(i));
        	mins = mins + findMinutes(timelist.get(i-1), timelist.get(i));
        }
        
        System.out.println("Journey time: "+ hours + " hours and " + mins + " minutes");
	}
	
	private static boolean checkExists(String[] array, String airport) {		//Checks if airport exists in airports array
		
				for (String str : array) {		// for all airports in the array										
				
				if (airport.equals(str)) {		// if the airport exists
					
					return true;
				}
			}	
		return false;
	}

	private static int findHours(int t1, int t2) {	// method for finding hours between times
	   
		int hours;
	   
	    if (t1>t2) {					// if the departure time is later than arrival time
	    	
	    	hours = ((2400 - t1) + t2);	//calculate the difference in time
	    }
	    else {
	    	
	    	hours = (t2 - t1);
	    }
	    	
	    return hours/100;				// return hours
	}
	
	private static int findMinutes(int t1, int t2){	// method for finding minutes between times
		
		int minutes;
		
		t1 = t1 % 100;					// change time 1 to only show minutes
		t2 = t2 % 100;					// change time 2 to only show minutes

		if (t1>t2) {					// if time 1 is later than time 2
			
			minutes = ((60 - t1) + t2);	// calculate the difference in time
		}
		else{
			
			minutes = (t2 - t1);		
		}
		
		return minutes;					// return minutes
	}
	
}