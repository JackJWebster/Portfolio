package spell;

import java.util.Iterator;
import java.util.LinkedList;

public class ListDictionary implements Dictionary{
	
	private LinkedList<String> list = new LinkedList<String>();	  
	
	public ListDictionary(){}

	@Override
	public void insert(String key){
	
		list.add(key);
		
	}

	@Override
	public void remove(String key) throws DictionaryException {
		
		if (!list.remove(key));
		throw new DictionaryException("Word not found");

	}

	@Override
	public boolean find(String key) {

		if(list.contains(key)) {
					
			return true;
					
		} else {
					
			return false;
			
			}
	}

	@Override
	public Iterator elements() {
		 
		Iterator<String> it = new Iterator<String>() {

	            @Override
	            public boolean hasNext() {
	            	
	            	return false;
	            		            		
	            }

	            @Override
	            public String next() {
	            	
	                return null;
	            }

	            @Override
	            public void remove() {
	                // TODO Auto-generated method stub
	            }
	        };
	        return it;
	}

}
