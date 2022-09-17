//Pet Database Program

package com.java;

import java.util.Scanner;

public class PetDatabase {

    public static void main(String[] args) throws Exception {
        //scanner for user input
        Scanner input = new java.util.Scanner(System.in);
        //int for user choice
        int userChoice = 0;
        //string of user input for pet name and age
        String petInput = "";
        //string of user input for pet name and age
        int petIdInput = 0;
        //string array for temporilary storing pet name and age
        String[] inputArray = new String[1];
        //counter to display number of pets added
        int counter = 0;
        //check if choice input is valid
        boolean number = false;
        // check if pet input valid for name and age
        boolean full = false;

        //initiate pet table class
        PetTable pt = new PetTable();
        //initiate pet file
        PetFile pf = new PetFile();

        //loads into existing file if found
        try {
            pf = (PetFile) PetTable.load("petFile.txt");
            pt.setArrayId(pf.id);
            pt.setArrayName(pf.name);
            pt.setArrayAge(pf.age);
        } catch (Exception e) {
            System.out.println("No file to load.\n");
        }

        //greets user and display choices
        System.out.println("Pet Database Program.\n");
        while (userChoice != 4) {
            System.out.println("What would you like to do?\n"
                    + "1) View all pets\n"
                    + "2) Add more pets\n"
                    + "3) Remove an existing pet\n"
                    + "4) Exit program\n"
                    + "Your choice:");

            //prompt user to enter choice
            try {
                userChoice = input.nextInt();
                input.nextLine();
                System.out.println("");
            } catch (Exception e) {
                while (number = false) {
                    userChoice = input.nextInt();
                    if (userChoice > 0) {
                        number = true;
                    }
                }
                input.nextLine();
                System.out.println("");
            }

            //switch statement for user choice
            switch (userChoice) {
                case 1: //display pet table
                    pt.table();
                    break;
                case 2: //prompt user to add pet name and age
                    while (true) {
                        System.out.println("Type 'done' or add pet (name, age): ");
                        petInput = input.nextLine();
                        if (petInput.equals("done")) {
                            break;
                        } else {
                            for (int i = 0; i < 1; i++) {
                                inputArray = petInput.split(" ");
                            }
                            try {
                                if (Integer.parseInt(inputArray[1]) > 20 || Integer.parseInt(inputArray[1]) < 0) {
                                    System.out.println("Error: " + Integer.parseInt(inputArray[1]) + " is not a valid input.");
                                } else {
                                    if (pt.limitCheck(full)) {
                                        System.out.println("Error: Database is full.");
                                        break;
                                    } else {
                                        pt.addPetAge(Integer.parseInt(inputArray[1]));
                                        pt.addPetName(inputArray[0]);
                                        pt.addPetId();
                                        counter++;
                                    }
                                }
                            } catch (Exception e) {
                                System.out.println("Error: " + petInput + " is not a valid input.");
                            }
                        }
                    }
                    System.out.println(counter + " pets added.\n");
                    counter = 0;
                    break;
                case 3: //delete pet
                    pt.table();
                    try {
                        System.out.println("Enter the pet ID to remove: ");
                        petIdInput = input.nextInt();
                        pt.deletePet(petIdInput);
                    } catch (Exception e) {
                        System.out.println("Error: ID " + petIdInput + " does not exist.\n");
                        break;
                    }
                    break;
                case 4: //ends program
                    System.out.println("Goodbye!");
                    break;
                default: //prompts user to re-enter choice
                    System.out.println("Please re-enter your choice.\n");
                    break;
            }
        }
        //sets current pet array lists to pet file
        pf.id = pt.getArrayId();
        pf.name = pt.getArrayName();
        pf.age = pt.getArrayAge();
        
        //saves array lists in text file
        try {
            pt.save(pf, "petFile.txt");
            System.out.println("\nFile was saved.");
        } catch (Exception e) {
            System.out.println("\nCould not save file.");
        }
    }
}
