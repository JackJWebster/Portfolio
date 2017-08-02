#pragma once
#ifndef NODE_H
#define NODE_H

#include <math.h>

class Node {

	int xPos; // Position on X and Y axis
	int yPos;
	int tDist; // Total distance travelled to reach node
	int priority; // Lower number = higher priority

public:

	Node(int xp, int yp, int td, int p) {

		xPos = xp;
		yPos = yp;
		tDist = td;
		priority = p;
	}

	int getXPos() const { return xPos; }
	int getYPos() const { return yPos; }
	int getTDist() const { return tDist; }
	int getPriority() const { return priority; }

	void updatePriority(const int & xFin, const int & yFin) {
		priority = tDist + estimate(xFin, yFin) * 10; // Calculate estimated distance to end position, with
	}												// weight of 10 for each node

	void nextNode(const int & i) {
		tDist += i % 2 == 0 ? 10 : 14; // if next node is diagonal add weight of
	}

	const int & estimate(const int & xFin, const int & yFin) const {

		static int xd, yd, d;

		xd = xFin - xPos; // Number of nodes between current position and
		yd = yFin - yPos; // end position along x and y axis

		d = abs(xd) + abs(yd); // Manhattan distance

		return(d);
	}								// 15, otherwise 10, favours straight lines
};

#endif