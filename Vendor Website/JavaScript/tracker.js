"use strict";

//Constructor for the Tracker object
export class Tracker {
    //Holds the keywords
    keywords = {};

    //Keywords older than this window will be deleted
    timeWindow = 1800000;

    constructor(){
        this.load();
    }

    //Adds a keyword to the Tracker
    addKeyword(word){
        //Increase count of keyword
        if(this.keywords[word] === undefined)
            this.keywords[word] = {count: 1, date: new Date().getTime()};
        else{
            this.keywords[word].count++;
            this.keywords[word].date = new Date().getTime();
        }
        
        
        //Save state of Tracker
        this.save();
    }

    //Returns the most popular keyword
    getTopKeyword(){
        //Clean up old keywords
        this.deleteOldKeywords();
        
        //Return word with highest count
        let maxCount = 0;
        let maxKeyword = "";
        for(let word in this.keywords){
            if(this.keywords[word].count > maxCount){
                maxCount = this.keywords[word].count;
                maxKeyword = word;
            }
        }
        return maxKeyword;
    }

    /* Saves state of Tracker */
    save(){
        localStorage.TrackerKeywords = JSON.stringify(this.keywords);
    };

    /* Loads state of Tracker */
    load(){
        if(localStorage.TrackerKeywords === undefined)
            this.keywords = {};
        else
            this.keywords = JSON.parse(localStorage.TrackerKeywords);
        
        //Clean up keywords by deleting old ones
        this.deleteOldKeywords();
    };
    
    //Removes keywords that are older than the time window
    deleteOldKeywords(){
        let currentTimeMillis = new Date().getTime();
        for(let word in this.keywords){
            if(currentTimeMillis - this.keywords[word].date > this.timeWindow){
                delete this.keywords[word];
            }
        }
        this.save();
    }
}
