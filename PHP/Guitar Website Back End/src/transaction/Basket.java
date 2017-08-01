package transaction;

import java.io.Serializable;
import java.util.ArrayList;

import javax.servlet.annotation.WebServlet;

public class Basket implements Serializable
{
	
	private static final long serialVersionUID = 1L;
	private ArrayList<TxtItem> items;
    
    public Basket()
    {
        items = new ArrayList<TxtItem>();
    }
    
    public ArrayList<TxtItem> getItems()
    { 
        return items;
    }
    
    public int getCount()
    { 
        return items.size();
    }
    
    public void addItem(TxtItem item)
    {
        String code = item.getProduct().getCode();
        int quantity = item.getQuantity();
        for (int i = 0; i < items.size(); i++)
        {
            TxtItem lineItem = items.get(i);
            if (lineItem.getProduct().getCode().equals(code))
            {
                lineItem.setQuantity(quantity);
                return;
            }
        }
        items.add(item);
    }
    
    public void removeItem(TxtItem item)
    {
        String code = item.getProduct().getCode();
        for (int i = 0; i < items.size(); i++)
        {
            TxtItem lineItem = items.get(i);
            if (lineItem.getProduct().getCode().equals(code))
            {
                items.remove(i);
                return;
            }
        }
    }
}
