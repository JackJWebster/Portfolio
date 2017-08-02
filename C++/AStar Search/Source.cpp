#include <iostream>
#include <queue>
#include <ctime>
#include <string>
#include <iomanip>
#include <math.h>
#include <Node.h>
using namespace std;

const int h = 60; // Horizontal map breadth
const int v = 60; // Vertical map length
static int map[h][v]; // Map grid
static int closedNodes[h][v]; // Map of closed nodes
static int openNodes[h][v];  // Map of open nodes
static int directions[h][v]; // Map of directions to take
const int nDir = 8; // Number of directions to go from any position
static int dirX[nDir] = { 1, 1, 0, -1, -1, -1, 0, 1 }; // Values representing 8 directions, each axis
static int dirY[nDir] = { 0, 1, 1,  1,  0, -1, -1, -1 }; // goes back and forward, includes diagonals

bool operator<(const Node & a, const Node & b) { // Determine priority

	return a.getPriority() > b.getPriority();
}

string pathFind(const int & xStart, const int & yStart, const int & xFin, const int & yFin) {

	static priority_queue<Node> pq[2];
	static int pqi;
	static Node* n0;
	static Node* m0;
	static int i, j, x, y, xdx, ydy;
	static char c;
	pqi = 0;

	for (y = 0; y<v; y++) // reset the node maps
	{
		for (x = 0; x<h; x++)
		{
			closedNodes[x][y] = 0;
			openNodes[x][y] = 0;
		}
	}

	n0 = new Node(xStart, yStart, 0, 0); // Create starting node and push it into open node list
	n0->updatePriority(xFin, yFin);
	pq[pqi].push(*n0);
	openNodes[x][y] = n0->getPriority(); // Tag priority on open nodes map

	while (!pq[pqi].empty()) {

		n0 = new Node(pq[pqi].top().getXPos(), pq[pqi].top().getYPos(), pq[pqi].top().getTDist(), pq[pqi].top().getPriority());
		x = n0->getXPos();
		y = n0->getYPos();

		pq[pqi].pop(); // Remove node from open node list
		openNodes[x][y] = 0;
		closedNodes[x][y] = 1; // Tag node on closed node list

		if (x == xFin && y == yFin) { // Stop searching when end position has been reached

			string path = ""; // Generate string path from directions
			while (!(x == xStart && y == yStart)) {

				j = directions[x][y];
				c = '0' + (j + nDir / 2) % nDir;
				path = c + path;
				x += dirX[j];
				y += dirY[j];
			}

			delete n0; // delete collection

			while (!pq[pqi].empty()) // Empty leftover nodes
				pq[pqi].pop();

			return path;
		}

		for (i = 0; i<nDir; i++) { // Generate moves in all directions

			xdx = x + dirX[i];
			ydy = y + dirY[i];

			if (!(xdx<0 || xdx>h - 1 || ydy<0 || ydy>v - 1 || map[xdx][ydy] == 1 || closedNodes[xdx][ydy] == 1)) {

				m0 = new Node(xdx, ydy, n0->getTDist(), n0->getPriority()); // Generate child node
				m0->nextNode(i);
				m0->updatePriority(xFin, yFin);

				if (openNodes[xdx][ydy] == 0) { // If the node is not in the open node map, add it

					openNodes[xdx][ydy] = m0->getPriority();
					pq[pqi].push(*m0);
					directions[xdx][ydy] = (i + nDir / 2) % nDir; // Tag its parent node direction
				}
				else if (openNodes[xdx][ydy]>m0->getPriority()) {

					openNodes[xdx][ydy] = m0->getPriority(); // Update priority info
					directions[xdx][ydy] = (i + nDir / 2) % nDir; // Update parent direction info

					while (!(pq[pqi].top().getXPos() == xdx && pq[pqi].top().getYPos() == ydy)) {

						pq[1 - pqi].push(pq[pqi].top());
						pq[pqi].pop();
					}

					pq[pqi].pop(); // Remove wanted node

					if (pq[pqi].size()>pq[1 - pqi].size()) // Empty the larger priority queue into the smaller one
						pqi = 1 - pqi;

					while (!pq[pqi].empty()) {

						pq[1 - pqi].push(pq[pqi].top());
						pq[pqi].pop();
					}

					pqi = 1 - pqi;
					pq[pqi].push(*m0); // Add the better node
				}

				else delete m0; // Delete node
			}
		}

		delete n0; // Delete node
	}

	return ""; // No route was found
}

int main() {

	srand(time(NULL));

	for (int y = 0; y<v; y++) { // Create empty map

		for (int x = 0; x<h; x++)
			map[x][y] = 0;
	}

	for (int x = h / 8; x<h * 7 / 8; x++) { // Fill map matrix with a '+' pattern

		map[x][v / 2] = 1;
	}

	for (int y = v / 8; y<v * 7 / 8; y++) {

		map[h / 2][y] = 1;
	}

	int xA, yA, xB, yB; // Randomly select start and finish locations
	switch (rand() % 8) {
	case 0: xA = 0; yA = 0; xB = h - 1; yB = v - 1; break;
	case 1: xA = 0; yA = v - 1; xB = h - 1; yB = 0; break;
	case 2: xA = h / 2 - 1; yA = v / 2 - 1; xB = h / 2 + 1; yB = v / 2 + 1; break;
	case 3: xA = h / 2 - 1; yA = v / 2 + 1; xB = h / 2 + 1; yB = v / 2 - 1; break;
	case 4: xA = h / 2 - 1; yA = 0; xB = h / 2 + 1; yB = v - 1; break;
	case 5: xA = h / 2 + 1; yA = v - 1; xB = h / 2 - 1; yB = 0; break;
	case 6: xA = 0; yA = v / 2 - 1; xB = h - 1; yB = v / 2 + 1; break;
	case 7: xA = h - 1; yA = v / 2 + 1; xB = 0; yB = v / 2 - 1; break;
	}

	cout << "Map Size (X,Y): " << h << "," << v << endl;
	cout << "Start: " << xA << "," << yA << endl;
	cout << "Finish: " << xB << "," << yB << endl;

	clock_t start = clock();
	string route = pathFind(xA, yA, xB, yB); // Get the route
	if (route == "") cout << "An empty route generated!" << endl;
	clock_t end = clock();
	double time_elapsed = double(end - start);
	cout << "Time to calculate the route (ms): " << time_elapsed << endl;
	cout << "Route:" << endl;
	cout << route << endl << endl;

	if (route.length()>0) { // Follow the route on the map and display it 

		int j;
		char c;
		int x = xA;
		int y = yA;
		map[x][y] = 2;
		for (int i = 0; i<route.length(); i++) {

			c = route.at(i);
			j = atoi(&c);
			x = x + dirX[j];
			y = y + dirY[j];
			map[x][y] = 3;
		}

		map[x][y] = 4;

		for (int y = 0; y<v; y++) { // Display the map with the route
			for (int x = 0; x<h; x++)
				if (map[x][y] == 0)
					cout << ".";
				else if (map[x][y] == 1)
					cout << "O"; //obstacle
				else if (map[x][y] == 2)
					cout << "S"; //start
				else if (map[x][y] == 3)
					cout << "R"; //route
				else if (map[x][y] == 4)
					cout << "F"; //finish
			cout << endl;
		}
	}
	getchar(); // Wait for Enter keypress  
	return(0);
}