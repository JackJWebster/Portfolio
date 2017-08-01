import datalink.*;

/*
  A go-back n type sliding window protocol
  */

public class GoBackNY extends Protocol
{
    int nextBufferToSend;        // buffer to be sent when channel is idle
    int firstFreeBufferIndex;    // buffer to getin which to store next packet
    int nextSequenceNumberExpected;  // sequence number expected
    int firstUnAcknowledged;     // last unacknowledged frame
    final int maximumSequenceNumber;
    int numberOfPacketsStored;
    final int windowSize;

    Packet[] buffer;
    double timer;

    public GoBackNY(int windowSize, double timer)
    {
	super( windowSize, timer);
	numberOfPacketsStored = 0;
	nextBufferToSend = 0;
	firstFreeBufferIndex= 0;
	nextSequenceNumberExpected = 0;
	firstUnAcknowledged = 0;
	maximumSequenceNumber = windowSize;
	this.windowSize = windowSize;
	this.timer = timer;
	buffer = new Packet[windowSize+1];
    }
    
/***********************************************************************/ 

    public void FrameArrival( Object frame)
    {
    	
	DLLFrame f = (DLLFrame) frame;

	if (f.isAck == 0) {

		if (f.sequenceNumber == nextSequenceNumberExpected)
		{
			sendPacket(f.info);
			nextSequenceNumberExpected = inc( nextSequenceNumberExpected);
			}
		
		if ( isChannelIdle())
		{
			transmit_ackframe();
			}
		
		acknowledge(f.acknowledgment);
	
		if ( numberOfPacketsStored < windowSize )
	    enableNetworkLayer();
		
	} else {
    	acknowledge(f.acknowledgment);
    	}
	}
    
/***********************************************************************/    
    
    public void acknowledge(int ack)
    {
    	while(between(firstUnAcknowledged,
      			 	  ack,
      			 	  nextBufferToSend))
    	{
      		numberOfPacketsStored--;
      		stopTimer(firstUnAcknowledged);
      		firstUnAcknowledged = inc( firstUnAcknowledged);
      		}
    	
    	if(numberOfPacketsStored < windowSize)
	     enableNetworkLayer();
    	
    }
    
/***********************************************************************/

    public void PacketArrival( Packet p)
    {
	
    	buffer[firstFreeBufferIndex] = p;
    	numberOfPacketsStored++;		/* buffer packet */
    	
    	if ( numberOfPacketsStored >= windowSize )
	    disableNetworkLayer();
    	
    	if ( isChannelIdle() )
	    {
    		transmit_frame( nextBufferToSend);
    		nextBufferToSend = inc( nextBufferToSend);
    		}
	
    	firstFreeBufferIndex = inc( firstFreeBufferIndex);
    	
    	}
    
/***********************************************************************/

    public void TimeOut( int code)
    {
    	nextBufferToSend = firstUnAcknowledged;
    	
    	if ( isChannelIdle() )
    	{
    		transmit_frame( nextBufferToSend);
    		nextBufferToSend = inc( nextBufferToSend);
    		}
    	}

/***********************************************************************/ 

    public void ChannelIdle()
    {
    	if ( nextBufferToSend != firstFreeBufferIndex )
    	{
    		transmit_frame( nextBufferToSend);
    		nextBufferToSend = inc( nextBufferToSend);
    		}
    	}
    
/***********************************************************************/

    private boolean between( int a, int b, int c)
    {
    	if(((a<=b) && (b<c))
    	|| ((c<a) && (a<=b))
    	|| ((b<c) && (c<a)))
    		return true;
    	else
    		return false;
    	}
    
/***********************************************************************/

    private int inc ( int a)
    {  
    	a++;
    	a %= maximumSequenceNumber+1;
    	return a;
    	}
    
/***********************************************************************/

    private void transmit_frame( int sequenceNumber)
    {
    	int acknowledgement;

    	acknowledgement = (nextSequenceNumberExpected+maximumSequenceNumber) % (maximumSequenceNumber+1);

    	sendFrame(new DLLFrame(0,sequenceNumber,
				               acknowledgement,
				               buffer[sequenceNumber]));
    	startTimer( sequenceNumber, timer);
    	}
    
/***********************************************************************/
    
    private void transmit_ackframe()
    {
    	int acknowledgement;

    	acknowledgement = (nextSequenceNumberExpected+maximumSequenceNumber) % (maximumSequenceNumber+1);
    	
    	sendFrame( new DLLFrame(1, acknowledgement));
    	}
    
    
    
    public void CheckSumError(){}
    }





class DLLFrame
{ /* frame structure */
	int isAck;
    int sequenceNumber;
    int acknowledgment;
    Packet info;

    DLLFrame (int i, int s, int a, Packet p)
    {
    	isAck = i;
    	info = p;
    	sequenceNumber = s;
    	acknowledgment = a;
    }
    
    DLLFrame (int i, int a)
    {
    	isAck = i;
    	acknowledgment = a;
    }

}
