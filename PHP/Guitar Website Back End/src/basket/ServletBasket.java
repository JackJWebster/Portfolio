package basket;

import java.io.*;

import javax.servlet.*;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.*;

import transaction.*;
import data.*;

public class ServletBasket extends HttpServlet {
	private static final long serialVersionUID = 1L;

	protected void processRequest(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		
		String productCode = request.getParameter("productCode");
		String quantityAsString = request.getParameter("quantity");

		HttpSession session = request.getSession();

		synchronized (session) {
			Basket basket = (Basket) session.getAttribute("basket");
			if (basket == null) {
				basket = new Basket();
				session.setAttribute("basket", basket);
			}

			int quantity = 1;
			try {
				quantity = Integer.parseInt(quantityAsString);
				if (quantity < 0)
					quantity = 1;
			} catch (NumberFormatException nfe) {
				quantity = 1;
			}

			ServletContext sc = getServletContext();
			String path = sc.getRealPath("WEB-INF/products.txt");
			Product product = TxtToProduct.getProduct(productCode, path);

			TxtItem lineItem = new TxtItem();
			lineItem.setProduct(product);
			lineItem.setQuantity(quantity);
			if (quantity > 0)
				basket.addItem(lineItem);
			else if (quantity <= 0)
				basket.removeItem(lineItem);

			session.setAttribute("basket", basket);
		}

		String url = "/Basket.jsp";
		RequestDispatcher dispatcher = getServletContext()
				.getRequestDispatcher(url);
		dispatcher.forward(request, response);
	}

	protected void doGet(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		processRequest(request, response);
	}

	protected void doPost(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		processRequest(request, response);
	}

	public String getServletInfo() {
		return "Short description";
	}
}
