/* Get all movies with an average rating of 9 or above*/
SELECT primaryTitle, IMDBratings.averageRating
FROM IMDBbasics
    INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst
WHERE IMDBratings.averageRating > 8


/*Get all movies with a certain keyword in the title with an average rating of 8 or above*
   "Wolf" is used as an example here, simply replace the word with whatever keyword the user inputs*/

SELECT primaryTitle, IMDBratings.averageRating
FROM IMDBbasics
    INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst
WHERE IMDBratings.averageRating > 7 AND primaryTitle LIKE "%Wolf%"

/* Get all movies with a certain keyword, above average rating, and released after a certain year*/
SELECT primaryTitle, IMDBratings.averageRating
FROM IMDBbasics
    INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst
WHERE IMDBratings.averageRating > 8 AND primaryTitle LIKE "%Wolf%" AND startYear >= 2010


/* Get the titles of the 10 best movies by genre
   Just switch out "Horror" to another genre if pref.*/
SELECT primaryTitle, IMDBratings.averageRating
FROM IMDBbasics
    INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst
WHERE genres="Horror"
ORDER BY averageRating DESC
LIMIT 10