package spell;

public class StringHashCode implements HashCode{
	
	private int size;
	
	public StringHashCode(int hashTableSize){		// Constructor which takes the HashTable size as a parameter
		
		size = hashTableSize;
		
	}
		
	public int giveCode(Object key) {		// method that calculates a hash code for the input string
		
		int hash=0;
		int n=31;
		String word = key.toString();
		
		for(int i=0;i<word.length();i++) {		// for every character of the word
			   
		  hash = (hash*n + (word.charAt(i) - 48)) % size;		// calculate the hash value
		  
		}
			
			return hash;
			
		}
	}
