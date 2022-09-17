package com.java;

import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.io.Serializable;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.ArrayList;

public class PetTable implements java.io.Serializable {

    //array list for pet id, name, age
    private ArrayList<Integer> id = new ArrayList<>();
    private ArrayList<String> name = new ArrayList<>();
    private ArrayList<Integer> age = new ArrayList<>();

    //to print previous name and age
    private String previousName = new String();
    private int previousAge = 0;

    //no-args default constructor
    public PetTable() {
    }

    public void setArrayId(ArrayList<Integer> id) {
        this.id = id;
    }

    public ArrayList<Integer> getArrayId() {
        return id;
    }

    public void setArrayName(ArrayList<String> name) {
        this.name = name;
    }

    public ArrayList<String> getArrayName() {
        return name;
    }

    public void setArrayAge(ArrayList<Integer> age) {
        this.age = age;
    }

    public ArrayList<Integer> getArrayAge() {
        return age;
    }

    //creates table and get info from array lists
    public void table() {
        System.out.printf("+----------------------+\n");
        System.out.printf("%-3s %-10s %4s", "ID", "NAME", "AGE\n");
        System.out.println("+----------------------+");
        if (id.size() == 0) {
            System.out.print("\n");
        } else {
            for (int i = 0; i < id.size(); i++) {
                System.out.printf("%-3s %-10s %4s", id.get(i), name.get(i), age.get(i) + "\n");
            }
        }
        System.out.println("+----------------------+");
        System.out.println(id.size() + " row(s) in set.\n");
    }

    //add pet id to id array list
    public void addPetId() {
        if (id.size() == 0) {
            id.add(0);
        } else {
            id.add(id.size());
        }
    }

    //add pet name to name array list
    public void addPetName(String petName) {
        name.add(petName);
    }

    //add pet age to age array list
    public void addPetAge(int petAge) {
        age.add(petAge);
    }

    //tells user if list is full
    public boolean limitCheck(boolean full) {
        if (id.size() == 5) {
            return true;
        } else {
            return false;
        }
    }

    //delete pet by id
    public void deletePet(int petId) {
        previousName = name.get(petId);
        previousAge = age.get(petId);
        id.remove(petId);
        name.remove(petId);
        age.remove(petId);
        System.out.println(previousName + " " + previousAge + " was removed.\n");
    }

    //saves a text file using the instances from PetFile class
    public static void save(Serializable data, String fileName) throws Exception {
        try (ObjectOutputStream output = new ObjectOutputStream(Files.newOutputStream(Paths.get(fileName)))) {
            output.writeObject(data);
        }
    }

    //loads existing text file
    public static Object load(String fileName) throws Exception {
        try (ObjectInputStream input = new ObjectInputStream(Files.newInputStream(Paths.get(fileName)))) {
            return input.readObject();
        }
    }
}
