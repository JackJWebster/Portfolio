package spell;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Iterator;

public class HashDictionary implements Dictionary{
	
	private static String[] HashTable;		// declare HashTable as String array
	private static int arraySize;			// declare size of HashTable									  
	private static int noOperationsSoFar = 0;		// declare number of operations so far
	private static float noProbesSoFar = (float) 0;		// declare number of probes so far
	
	
	public HashDictionary() throws DictionaryException{throw new DictionaryException("");}	// empty constructor, throws exception if called
	
	
	public HashDictionary(HashCode inputCode, float inputLoadFactor) {		// constructor, takes HashCode object and float load factor as parameters
		
		int size = 7;		// set initial size of HashTable
		arraySize = size;		// initialise arraySize 
		HashTable = new String[arraySize];		// initialise HashTable of size arraySize
		
	}
	
	
	public void insert(String key) {		// method for inserting string into HashTable with input string as parameter
		
		int hashKey, doubleHashKey;		
		double loadFactor;
		int itemsInArray = 0;
		float inputLoadFactor = (float) 0.5;
		float sizeArray = (float) arraySize;
		String stringToHashTable;
		StringHashCode q = new StringHashCode(arraySize);
		
		noOperationsSoFar++;		// increment number of operations so far for calling insert
		noProbesSoFar++;		// increment number of probes so far for inserting string
		
		stringToHashTable = key;		// set stringToHashTable to string parameter key
		hashKey = q.giveCode(key);		// set hashKey to hashCode given from the key
		
		if ((HashTable[hashKey] != null) && (HashTable[hashKey] != "-----")) {		// if the HashTable index contains a valid entry
			
			doubleHashKey = doubleHash(hashKey);		// set doubleHashKey to the hashed hashKey
			hashKey = hashProbe(hashKey, doubleHashKey);		// set hashKey to the hash code given from probing
			HashTable[hashKey] = stringToHashTable;		// insert the string into the HashTable at index, hashKey
		}
		
		else {		// if the index of the HashTable contains 'null' or '-----'
			
		HashTable[hashKey] = stringToHashTable;		//insert the string into the HashTable at the original index before double hashing
	}
		
		for ( int i = 0; i<HashTable.length; i++){		// for all the indexes in the HashTable
			
			if ((HashTable[i] != null) && (HashTable[i] != "-----")) {		//if it contains a valid entry
				
				itemsInArray++;		// increment itemsInArray
			}
			
		}
		
		loadFactor = (itemsInArray / sizeArray);		// calculate loadFactor
		
		if ( loadFactor > inputLoadFactor) {		// if the load factor is bigger than the inputLoadFactor
			
			ReHash(HashTable);		// rehash the HashTable
			
			}
	
	}


	public boolean find(String key) {		// method for finding strings in the HashTable
		
		String stringKey = key;		// set StringKey as the string to find
		int hashToFind;
		StringHashCode sH = new StringHashCode(arraySize);
		
		noOperationsSoFar++;		// increment for calling find()
		
		hashToFind = sH.giveCode(stringKey);		// calculate hash code of the string to find
	
		if ( stringKey.equals(HashTable[hashToFind])) {		// if the string exists in the HashTable
			
			return true;
			
		} else {
			
				return findDoubleHash(hashToFind, key);		// try finding the double hashed string
			 
		}
	}


	private boolean findDoubleHash(int hash, String key) {		// method for finding double hashed strings
		
		String stringKey = key;		// set stringKey to the string to find
		int hashToFind = hash;
		int doubleHashKeyValue;
	
		doubleHashKeyValue = doubleHash(hashToFind);		// calculate the double hash value
				
				while ((HashTable[hashToFind] != null) && (HashTable[hashToFind] != "-----")) {		// while the HashTable already contains a string
					
					hashToFind += doubleHashKeyValue;		// increase hash code by double hashed value
					
					hashToFind %= arraySize;		// if value reaches the HashTable size, return to the start of the HashTable
					
					if ( stringKey.equals(HashTable[hashToFind]) ){		// if the HashTable contains the string to find
						
						return true;
					}
				}
				
		return false;		// string could not be found
	}


	public void remove(String key) throws DictionaryException{		// method for removing strings from HashTable
	
	String stringToRemove = key;		// set stringToRemove to the string to remove
	int hashToFind, doubleHashKeyValue;
	boolean found = false;
	
	noOperationsSoFar++;		// increment number of operations so far for calling remove
	
	StringHashCode sH = new StringHashCode(arraySize);
	
	hashToFind = sH.giveCode(stringToRemove);		// calculate hash code for string to remove
	
	if ( stringToRemove.equals(HashTable[hashToFind]) ) {		// if the HashTable contains the string
		
		HashTable[hashToFind] = "-----";		// insert '-----' into the index, to avoid errors when finding double hashed strings 
		
		System.out.println(stringToRemove + " has been removed from index " + hashToFind);
		
		found = true;		// string was found and removed
	
	} else {		// if the string was not found
		
		 doubleHashKeyValue = doubleHash(hashToFind);		// calculate double hash value for string
			 
				while (HashTable[hashToFind] != null) {		// while HashTable index doesn't contain 'null'
					
					hashToFind += doubleHashKeyValue;		// increase hash code by the double hashed value
					
					hashToFind %= arraySize;		// if value reaches HashTable size, return to start of HashTable
					
					if ( stringToRemove.equals(HashTable[hashToFind]) ){		// if the HashTable index contains the string to remove
						
						HashTable[hashToFind] = "-----";		// insert '-----' into the index
						
						System.out.println(stringToRemove + " has been removed from index " + hashToFind);
						
						found = true;		// string was found and removed
					}
				}
	}
	
	if ( found == false)		// if the string was not found
		
		throw new DictionaryException(stringToRemove + " does not exist");		// throw exception
	
	}


	private boolean checkForPrime(int numberToCheck) {		// method for checking prime numbers
		
		   if (numberToCheck <= 1) {		// if number is 1 or 0, therefore not prime
			   
		       return false;
		       
		   }
		   
		   for (int i = 2; i < Math.sqrt(numberToCheck); i++) {		// for all numbers between 2 and the square root of the 'prime to check'
			   
		       if (numberToCheck % i == 0) {		// if the prime is divisible by any of the numbers, it is not prime
		    	   
		           return false;
		           
		       }
		   }
		   
		   return true;		// the number has no factors and is not 1 or 0, therefore prime
	}
		
	
	private int getNextPrime(int minimumPrime){		// method for getting the next prime after the minimum value, inputed as a parameter
		
		for (int i = minimumPrime; true; i++) {		// starting from the minimum value and increment
			
			if (checkForPrime(i)) {		// check if the value is prime
				
				return i;		// if it is prime, return
				
			}
		}
	}
	
	
	private void ReHash(String[] arrayToRehash){		// method for rehashing HashTable once load factor is too large
		
		int newHashTableSize = getNextPrime(HashTable.length*2);		// create new HashTable with double, to the next prime, capacity
		
		moveHashTable(newHashTableSize);		// move values from old HashTable to new HashTable
		
	}
	
	
	private void moveHashTable(int tableSize) {		// method for moving old HashTable to new HashTable
		
		String[] sortedHashTable = removeEmptySpaces(HashTable);		// create new string array containing all valid entries, removing spaces
		
		HashTable = new String[tableSize];		// create new HashTable with the capacity passed from parameter
		arraySize = tableSize;		// set arraySize to new HashTable size
		
		Arrays.fill(HashTable, null);		// fill new HashTable with null values
		
		for ( int i = 0; i < sortedHashTable.length; i++) {		// for all entries in the sorted Hash Table
			
			insert(sortedHashTable[i]);		// insert the entries into the new HashTable
		}
	}
	
	
	private String[] removeEmptySpaces (String[] unsortedHashTable) {		// method to remove empty spaces in the HashTable
		
		ArrayList<String> sortedList = new ArrayList<String>();		// create ArrayList for holding valid entries
		
		for (String string : unsortedHashTable) {		// for every entry in the unsorted HashTable
			
			if ((string != (null)) && (string != "-----")) {		// if the index contains a valid entry
				
				sortedList.add(string);		// add the entry to the sortedList
				
			}
		}
		
			return sortedList.toArray(new String[sortedList.size()]);		// move entries from sortedList to a string array and return
		
	}

	
	private int doubleHash(int hashKey) {		// method for double hashing strings
		
		int hashKeyValue = hashKey;	
		
		hashKeyValue = 5 - hashKeyValue % 5;		// set the hashKeyValue as its calculated hash code using the secondary hash function
		
		return hashKeyValue;
	
	}
	
	
	private int hashProbe(int hashKey, int doubleHashKey){		// method for probing hashKeyValue, used for insert()
		
		int hashKeyValue = hashKey;
		int doubleHashKeyValue = doubleHashKey;
		
		while ((HashTable[hashKeyValue] != null) && (HashTable[hashKeyValue] != "-----")) {		// while the HashTable index is a valid entry
			
			noProbesSoFar++;		// increment number of probes so far for probing the hashKeyValue
			
			hashKeyValue += doubleHashKeyValue;		// increase hashKeyValue by double hash value
			
			hashKeyValue %= arraySize;		// if hashKeyValue reaches arraySize, return to start of HashTable
			
		}
		
		return hashKeyValue;
	}

	
	@Override
	public Iterator elements() {		// iterator for iterating through the HashTable
		
		  Iterator<String> it = new Iterator<String>() {

	            private int currentIndex = 0;		// set currentIndex to 0

	            @Override
	            public boolean hasNext() {
	                
	                while (currentIndex < arraySize) {
	                	
	                	 if (HashTable[currentIndex] != null && HashTable[currentIndex] != "-----") {		// if the HashTable index contains a valid entry
	     	                
	                		 return true;
	                		 
	                	 }
	                	
	                	currentIndex++;		// otherwise increment CurrentIndex, continues until valid entry is found
	                	
	                }
	                
					return false;
	            }

	            @Override
	            public String next() {
	            	
	                return HashTable[currentIndex++];
	                
	            }

	            @Override
	            public void remove() {
	               
	            	HashTable[currentIndex] = "-----";		// set HashTable index as '-----', to prevent errors when finding entries
	            	
	            }
	        };
	        
	        return it;
	        
	    }
	
	
	public static void printHashTable() {		// method used to print HashTable
		
		for ( int i = 0; i<HashTable.length; i++) {		// for all HashTable entries
			
			System.out.println(i + ": " +HashTable[i]);		// print HashTable index and corresponding entry
		}
	}
	
	public static float averNumProbes() {		// method for calculating average number of probes
		
		float averNumProbes = (float) 0;
		
		averNumProbes = noProbesSoFar/noOperationsSoFar;		// average number of probes equals number of probes so far divided by number of operations so far
		
		System.out.println("Operations so far: " + noOperationsSoFar);
		System.out.println("Number of probes so far: " + noProbesSoFar);
		
		return averNumProbes;
		
	}
}