package spell;

import java.io.*;
import java.util.ArrayList;
 
public class Spell {
   
	final static char[] alphabet = "abcdefghijklmnopqrstuvwxyz".toCharArray();
          
   
	
	
	public static void main(String[] args) throws java.io.IOException, DictionaryException{
		
		long startTime,breakTime,finishTime;
		double insertTime,findTime;
		
         if (args.length != 2 ) {
            System.out.println("Usage: spell dictionaryFile.txt inputFile.txt ");
            System.exit(0);
         }
         BufferedInputStream dict = null,file = null;
         
         try{
           
        	 dict  = new BufferedInputStream(new FileInputStream(args[0]));
             file  = new BufferedInputStream(new FileInputStream(args[1]));
	    // To read from specific files, comment the 2 lines above and 
            // uncomment 2 lines below 
            //dict  = new BufferedInputStream(new FileInputStream("C:/Users/Jack/Desktop/Workspace/spell/d1.txt"));
            //file  = new BufferedInputStream(new FileInputStream("C:/Users/Jack/Desktop/Workspace/spell/checkTest.txt"));
	   
         }
         catch (IOException e){ // catch exceptions caused by file input/output errors
            System.out.println("Check your file name");
            System.exit(0);
        }  
        
         StringHashCode sH = new StringHashCode(7);
         
         float fL = (float) 0.5;
         
         Dictionary hD = new HashDictionary(sH, fL);		// initialise a new HashDictionary or ListDictionary object
         
         FileWordRead fWR = new FileWordRead(dict);
         FileWordRead fWR2 = new FileWordRead(file);
         
         startTime = System.currentTimeMillis();		// start time for testing
         
         insertDic(hD, fWR);		//insert dictionary into dictionary object
         
         breakTime = System.currentTimeMillis();		// break for splitting times
         
         check(hD, fWR2);		// check dictionary for suggested correct spellings
         
         finishTime = System.currentTimeMillis();		// finish time for testing
         
         insertTime = breakTime - startTime;		// time taken to insert dictionary
         findTime = finishTime - breakTime;			// time taken to find suggested correct spellings
         
         System.out.println("Time to insert: " + insertTime + "\nTime to find: " + findTime);   
    }
	
	
	private static void insertDic(Dictionary hD, FileWordRead f) throws IOException, DictionaryException {
		
		while ( f.hasNextWord()) {		// while the dictionary file has a next word
       	 
       	 hD.insert(f.nextWord());		// insert it into the dictionary structure
       	 
        }
		
	}
    
    
	public static void check(Dictionary hD, FileWordRead f) throws IOException {
		
        String input;
        
        while (f.hasNextWord()) {		// if the test file has a next word
        	
        	input = f.nextWord();		// set input to that word
       
            if (input.equals("")) {		// if the input string is empty
               
            	break;
            	
            }
            
            if (hD.find(input)) {		// if the word is in the dictionary
            	
                System.out.println(input + " is spelled correctly");		// the word is spelled correctly
                
            } else {
               
                System.out.println(printSuggestions(hD, input));		// print suggestions for word
                
            }
        }
        
	}
	
	
	 private static String printSuggestions(Dictionary hD, String input) {		// method for printing suggestions for incorrectly spelled words 
		 
	        StringBuilder sb = new StringBuilder();
	        
	        ArrayList<String> print = makeSuggestions(hD, input);		// set ArrayList print to an ArrayList of suggestions
	        
	        if (print.size() == 0) {		// if the ArrayList is empty
	        	
	            return input + " has no suggestions.";
	            
	        } else {
	        
	        System.out.print(input + " => ");

	        for (String s : print) {		// for each suggestion in ArrayList print
	        	
	            sb.append(s + ", ");		// print the suggestion
	            
	        }
	        
	        return sb.toString();		// return input followed by suggestions
	        
	    }
	 }
    
	 
	 private static ArrayList<String> makeSuggestions(Dictionary hD, String input) {		// method for creating suggestions
		 
	        ArrayList<String> suggestions = new ArrayList<>();
	        		
	        suggestions.addAll(charOmission(hD, input));		// add suggestion to ArrayList suggestions
	        
	        suggestions.addAll(charReversal(hD, input));		// add suggestion to ArrayList suggestions
	        
	        suggestions.addAll(charInsertion(hD, input));		// add suggestion to ArrayList suggestions
	        
	        suggestions.addAll(charSubstitution(hD, input));		// add suggestion to ArrayList suggestions
	        
	        return suggestions;		// return ArrayList of suggestions
	        
	    }
	 

	    private  static ArrayList<String> charOmission(Dictionary hD, String input) {		// method for omitting characters
	    	
	        ArrayList<String> suggestions = new ArrayList<>();

	        int len = input.length() - 1;

	        if (hD.find(input.substring(1))) {		// remove the first character and check
	           
	        	suggestions.add(input.substring(1));		// if found, add to suggestions
	        	
	        }
	        
	        for (int i = 1; i < len; i++) {		// for each character in the word
	        
	            String working = input.substring(0, i);		
	            
	            working = working.concat(input.substring((i + 1), input.length()));		// remove each character in the word, not including the first or last characters
	            
	            if (hD.find(working) && !suggestions.contains(working)) {		// if the word is found and isn't already in the suggestions ArrayList, to avoid duplicates
	                
	            	suggestions.add(working);		// add to suggestions
	            	
	            }
	        }
	        
	        if (hD.find (input.substring(0, len))) {		// remove the last character and check
	           
	        	suggestions.add(input.substring(0, len));		// if found, add to suggestions 
	       
	        }
	       
	        return suggestions;		// return ArrayList of suggestions
	    }

	    
	    private static ArrayList<String> charReversal(Dictionary hD, String input) {		// method to check if two adjacent characters were swapped 
	        
	    	ArrayList<String> suggestions = new ArrayList<>();
	    	
	        for (int i = 0; i < input.length() - 1; i++) {		// for each character in the word
	        	
	            String working = input.substring(0, i);		// substring of characters before swapped characters
	            
	            working = working + input.charAt(i + 1);		// add the right adjacent character
	            
	            working = working + input.charAt(i);		// add the left adjacent chaarcter, therefore swapping them
	            
	            working = working.concat(input.substring(i + 2));		// add rest of string
	            
	            if (hD.find(working)) {		// if the word exists
	            	
	                suggestions.add(working);		// add it ot suggestions
	            
	            }
	       
	        }
	        
	        return suggestions;		// return ArrayList of suggestions
	   
	    }
	    
	    
	    private static ArrayList<String> charInsertion(Dictionary hD, String input) {		// method for adding a character into each position in the word
	    	
	    	ArrayList<String> suggestions = new ArrayList<>();
	    	String front, end;

	    	 for (char c : alphabet) {		// for each letter in the alphabet
		        	
		            front = c + input;		// add a character to the front of the word
		            
		            end = input + c;		// add a character to the back of the word
		            
		            if (hD.find(front)) {		// if the entry exists
		                
		            	suggestions.add(front);		// add to suggestions
		            
		            }
		            
		            if (hD.find(end)) {		// if the entry exists
		              
		            	suggestions.add(end);		// add to suggestions
		            
		            }
	    	
	    	for (int i = 1; i < input.length(); i++) {
		        
	    		String working, part1, part2;
		        	
	            part1 = input.substring(0, i);		// substring first part of word
	            
	            part2 = input.substring((i), input.length()); 		// substring second part of word     
	            
	            working = part1.concat(c + part2);		// put substrings together with character inbetween
	            
	            if (hD.find(working)) {		// if the entry exists
	               
	            	suggestions.add(working);		// add to suggestions
	            
	            }
	    	}
	    	 }
	    	 
	    	 return suggestions;		// return ArrayList of suggestions
			
	    }
	    
	    
	    private static ArrayList<String> charSubstitution (Dictionary hD, String input) {	// method for substituting each character for another character
			
	    	ArrayList<String> suggestions = new ArrayList<>();
	    	
	    	String working = input;
			
	    	for (int i = 0; i < input.length(); i++) {		// for each character in the word
	    		
	    		for (char c : alphabet) {		// for each letter in the alphabet
	    			
	    			working = input;
	    			
	    			StringBuilder sB = new StringBuilder(working);
	    			
	    			sB.setCharAt(i, c);		// replace character at i with c
	    			
	    			working = sB.toString();		// build string
	    			
	    			if (hD.find(working)) {		// if the entry exists
		            	
		                suggestions.add(working);		// add to suggestions
		            
	    			}
	    		}
	    	}
	    	
	    	return suggestions;		// return ArrayList of suggestions
	    	
	    }
}
