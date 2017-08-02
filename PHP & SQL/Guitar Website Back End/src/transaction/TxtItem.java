package transaction;

import java.io.Serializable;
import java.text.NumberFormat;

import javax.servlet.annotation.WebServlet;

public class TxtItem implements Serializable
{
    
	private static final long serialVersionUID = 1L;
	private Product product;
    private int quantity;
    
    public TxtItem() {}
    
    public void setProduct(Product p)
    {
        product = p;
    }

    public Product getProduct()
    { 
        return product;
    }

    public void setQuantity(int quantity)
    {
        this.quantity = quantity;
    }
    
    public int getQuantity()
    { 
        return quantity; 
    }
    
    public double getTotal()
    { 
        double total = product.getPrice() * quantity;
        return total;
    }
    
    public String getTotalCurrencyFormat()
    {
        NumberFormat currency = NumberFormat.getCurrencyInstance();
        return currency.format(this.getTotal());
    }
}
