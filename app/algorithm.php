<?php

function floydWarshall($graph, $V, $INF)
{
    /* prepare output matrix for every pair of vertices */
    $dist = [];
    foreach ($graph as $ind => $g) {
        foreach ($g as $key) {
            $dist[$ind][] = 0;
        }
    }
    $path = $dist;

    /* initial values for based on shortest paths considering no intermediate vertex. */
    for ($i = 0; $i < $V; $i++) {
        for ($j = 0; $j < $V; $j++) {
            $dist[$i][$j] = $graph[$i][$j];
            $path[$i][$j] = ($graph[$i][$j] > 0 && $graph[$i][$j] < $INF) ? 1 : 0;
        }
    }

    /* Add all vertices */
    for ($k = 0; $k < $V; $k++) {
        // Pick all vertices as source one by one
        for ($i = 0; $i < $V; $i++) {
            // Pick all vertices as destination
            // for the above picked source
            for ($j = 0; $j < $V; $j++) {
                // If vertex k is on the shortest path from
                // i to j, then update the value of dist[i][j]
                if (
                    $dist[$i][$k] + $dist[$k][$j] <
                    $dist[$i][$j]
                ) {
                    $dist[$i][$j] = $dist[$i][$k] +
                        $dist[$k][$j];
                    $path[$i][$j] = $path[$i][$k] +
                        $path[$k][$j];
                }
            }
        }
    }

    return [$dist, $path];
}
