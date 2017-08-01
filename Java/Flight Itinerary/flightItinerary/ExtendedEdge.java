package flightItinerary;

import org.jgrapht.graph.DefaultWeightedEdge;

public class ExtendedEdge extends DefaultWeightedEdge{
	private static final long serialVersionUID = 1L;
	
//	*******************************************************
//	* Part C : Additional Flight Information
//	*******************************************************
	
	String airport1;
	String airport2;
	String flightNumber;
	int departureTime;
	int arrivalTime;

    public ExtendedEdge(String airport1, String airport2, String flightNumber, int departureTime, int arrivalTime){
        this.airport1 = airport1;
        this.airport2 = airport2;
        this.flightNumber = flightNumber;
        this.departureTime = departureTime;
        this.arrivalTime = arrivalTime;
    }

    public String getAirport1(){
        return airport1;
    }

    public String getAirport2(){
        return airport2;
    }

    public String getFlightNumber(){
        return flightNumber;
    }
    
    public int getDepartureTime(){
    	return departureTime;
    }

	public int getArrivalTime(){
		return arrivalTime;
	}
}
