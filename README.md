# Oxbury Pathfind

Imagine representing a grid-shaped game map as a 2-dimensional array. Each value of this array is
boolean `true` or `false` representing whether that part of the map is passable (a floor) or blocked
(a wall).

Write a function that takes such a 2-dimensional array `A` and 2 vectors `P` and `Q`, with `0,0` being the top left corner of the map and returns the distance of the shortest path between those points, respecting the walls in the map.

eg. Given the map (where `.` is passable - `true`, and `#` is blocked - `false`)

```
. P . . .
. # # # .
. . . . .
. . Q . .
. . . . .
```

then `pathfind(A, P, Q)` should return `6`.

_Please avoid using libraries to implement the algorithmic side of this challenge, other libraries (such as PHPUnit or Jest for testing) are welcome._

## What to do

1. Clone/Fork this repo or create your own
2. Implement the function described above in any mainstream language you wish
3. Provide unit tests for your submission
4. Fill in the section(s) below

## Comments Section

<!---
Please fill in the sections below after you complete the challenge.
--->

### What I'm Pleased With

Overall it was an opportunity to experiment with a lot of new concepts and coding techniques.
During this project I researched different pathfinding algorithms, such as Dijksta's algorithm and A* algorithm (settling down on the latter). I also refereshed my knowledge on raw git, unit tests, file manipulation and multi-dimensional arrays, which I haven't had much contact with recently. 
I also appreciated the relative challenge, going from not remembering a thing about the required concept to an actual working implementation of the A* algorithm. It was a good learning opportunity.

### What I Would Have Done With More Time

1. Introduced more error-checking\validation throughout the program. The current version requires following the existing procedure more or less to the letter, or it will not work.
2. Dove deeper into the unit tests, perhaps testing the individual function instead of the whole command, as it is more inline with the concept of the unit test.
3. Provided more documentation of the working process.
4. Adapted the code for more varied scenarios, for example, weighted routes and 8-directional movement.
5. Provided some visual representation of the working algorithm, as looking at moving dots is always more interesting than looking at a number
