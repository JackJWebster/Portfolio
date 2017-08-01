import java.io.BufferedReader;
import java.io.FileReader;
import java.util.Random;

public class CycleGA {
	//choose the file name of the distances matrix you wish to run algorithm on
	//value of numberOfCities must be maintained when DISTANCE_FILENAME is changed
    private static String DISTANCE_FILENAME = "distances.txt";
    private static int numberOfCities = 8;

	//parameter settings
    private static int MAX_CITIES = 20;
    private static int MAX_POPULATION = 100;
    private static int populationSize = 25;
    private static int maxGenerations = 40;
    private static double mutateProbability = 0.3;
    private static double crossoverProbability = 0.25;
	private static Random random = new Random();

	//data structures
    private static double[][] distance;
    private static int[][] currentPopulation;
    private static int[][] intermediatePopulation;
    private static double[] fitness;
    private static int bestSolutionSoFar;
    private static double bestFitnessSoFar;
    private static int[] referenceSolution;
    
	private static void importMatrix() {

        int city1, city2;
        BufferedReader readbuffer = null;
        String strRead;
        String splitarray[];
        double inputNumberDouble;

        try {
            readbuffer = new BufferedReader(new FileReader(DISTANCE_FILENAME));
            for (city1 = 0; city1 < numberOfCities; city1++) {
                strRead = readbuffer.readLine();
                splitarray = strRead.split("\t");
                for (city2 = 0; city2 < numberOfCities; city2++) {
                    inputNumberDouble = Double.parseDouble(splitarray[city2]);
                    distance[city1][city2] = inputNumberDouble;
                }
            }
        } catch (Exception e) {
            System.out.println(e);
            System.exit(0);
        }
    }
	
	private static void createInitialPopulation() {

        int chromosome, i, a, index;

        bestFitnessSoFar = 0.0;

        for (chromosome = 0; chromosome < populationSize; chromosome++) {

            for (i = 0; i < numberOfCities; i++) {
                referenceSolution[i] = i;
            }
            
            for (i = numberOfCities - 1; i > 0; i--) {
              index = random.nextInt(i + 1);
              a = referenceSolution[index];
              referenceSolution[index] = referenceSolution[i];
              referenceSolution[i] = a;
            }
           
            swapper(referenceSolution, 0, 2);

            for (i = 0; i < numberOfCities; i++) {
                currentPopulation[chromosome][i] = referenceSolution[i];
            }
        }
    }
	
	private static void evaluatePopulation() {
	    int chromosome, to, from;
	    double total_distance;
	
	    for (chromosome = 0; chromosome < populationSize; chromosome++) {
	        total_distance = 0;
	        
	        for (int i = 0; i < numberOfCities-1; i++) {  
	        	to = currentPopulation[chromosome][i];
	        	from = currentPopulation[chromosome][i+1];
	            total_distance += distance[to][from];
	        }
	        total_distance += distance[currentPopulation[chromosome][numberOfCities-1]][currentPopulation[chromosome][0]];
	
	        fitness[chromosome] = 1/total_distance;
	
	        if (fitness[chromosome] >= bestFitnessSoFar) {
	            bestFitnessSoFar = fitness[chromosome];
	            bestSolutionSoFar = chromosome;
	        }
	    }
	
	    //prints the header for the table of chromosomes
	    System.out.println("Route \t\t\tFitness \t\tDistance");
	    //print the information for each chromosome in this generation
	    for (chromosome = 0; chromosome < populationSize; chromosome++) {
	
	    	//prints the route for the current chromosome
	        for (int i = 0; i < numberOfCities; i++) {
	            System.out.print(currentPopulation[chromosome][i] + " ");
	        }
	
	        //prints fitness and distance of the current chromosome
	        System.out.print("\t" + fitness[chromosome] + "\t" + Math.round(1/fitness[chromosome]) + " miles");
	        //if the current chromosome is the best solution so far, print to the console line
	        if (fitness[chromosome] == bestFitnessSoFar) {
	            System.out.print("   BEST ROUTE!!");
	        }
	        System.out.print("\n");
	    }
	    System.out.print("\n");
	}

	private static void produceTheNextGeneration() {

        int newCandidate, parent1, parent2, gene;
        int child[] = new int[MAX_CITIES];

        for (gene = 0; gene < numberOfCities; gene++) {
        	intermediatePopulation[0][gene] = currentPopulation[bestSolutionSoFar][gene];
        	}

        for (newCandidate = 1; newCandidate < populationSize; newCandidate++) {
            parent1 = rouletteWheelSelect();
            parent2 = rouletteWheelSelect();
            child = crossover(parent1, parent2, child);
            child = mutate(child);

            for (gene = 0; gene < numberOfCities; gene++) {
                intermediatePopulation[newCandidate][gene] = child[gene];
            }
        }

        for (newCandidate = 0; newCandidate < populationSize; newCandidate++) {
            for (gene = 0; gene < numberOfCities; gene++) {
                currentPopulation[newCandidate][gene] = intermediatePopulation[newCandidate][gene];
            }
        }
    }
	
    private static int[] swapper(int[] array, int index, int value) {
		int i, l,  k = 0;
		
		if (referenceSolution[index] != value) {
        	for (i = 0; i < numberOfCities; i++) {
        		if ( referenceSolution[i] == value)
        			k = i;
        	}
        	l = referenceSolution[index];
        	referenceSolution[index] = referenceSolution[k];
        	referenceSolution[k] = l;
        }

		return array;
	}
	
	private static int rouletteWheelSelect() {
        double fitTotal, pointer, accumulatingFitness, randReal;
        int chromosome, randint, selected;

        fitTotal = 0.0;
        accumulatingFitness = 0.0;
        
        for (chromosome = 0; chromosome < populationSize; chromosome++) {
            fitTotal += fitness[chromosome];
        }

        randint = getRandomNumberBetween(0, 1000001);
        randReal = randint / 1000000.0;
        pointer = fitTotal * randReal;

        for (selected = 0; selected < populationSize; selected++) {
            accumulatingFitness += fitness[selected];
            if (pointer < accumulatingFitness) {
                break;
            }
        }
        return selected;
    }
	
	private static int[] mutate(int[] child) {
    	int g, h, temp;
    	double rand;
    	
    	rand = Math.random();
    	
    	if (rand < mutateProbability) {
    	g = getRandomNumberBetween(1, numberOfCities);
        h = getRandomNumberBetween(1, numberOfCities);
        temp = child[g];
        child[g] = child[h];
        child[h] = temp;
        return child;
        } else {
    		return child;
    	}
    }
	
	private static int[] crossover(int parent1, int parent2, int[] child) {
        int[] selected;
        int i, index, a, rand1 = getRandomNumberBetween(0, 1000);
        double rand2 = Math.random();
        
        if (rand2 < crossoverProbability) {
        
        selected = new int[MAX_CITIES];

        for (i = 0; i < numberOfCities; i++) {
            if (rand1 < 500) {
                selected[i] = 1;
            } else {
                selected[i] = 0;
            }
        }
        
        for (i = 0; i < numberOfCities; i++) {
            if (selected[i] == 1) {
                child[i] = currentPopulation[parent1][i];
            } else {
            	if (selected[i] == 0) {
            		child[i] = currentPopulation[parent2][i];
            	}
            }
        }
        
        return child;
        } else {
        	  for (i = 0; i < numberOfCities; i++) {
                  referenceSolution[i] = i;
              }
              
              for (i = numberOfCities - 1; i > 0; i--) {
                index = random.nextInt(i + 1);
                a = referenceSolution[index];
                referenceSolution[index] = referenceSolution[i];
                referenceSolution[i] = a;
              }
             
              swapper(referenceSolution, 0, 2);

              for (i = 0; i < numberOfCities; i++) {
                  child[i] = referenceSolution[i];
        }
              return child;
        }
    }
	
	private static int getRandomNumberBetween(int min, int max) {
        return random.nextInt(max - min) + min;
    }

    //the main method
    public static void main(String[] s) {
        
    	distance = new double[MAX_CITIES][MAX_CITIES];
        currentPopulation = new int[MAX_POPULATION][MAX_CITIES];
        intermediatePopulation = new int[MAX_POPULATION][MAX_CITIES];
        fitness = new double[MAX_POPULATION];
        referenceSolution = new int[MAX_CITIES];

        System.out.println("INITIALISATION");
        importMatrix();
        createInitialPopulation();
        evaluatePopulation();

        for (int i=0; i < maxGenerations; i++) {
            System.out.println("GENERATION " + (i+1));
            produceTheNextGeneration();
            evaluatePopulation();
        }
	}
}
