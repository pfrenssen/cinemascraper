CinemaScraper
=============

I made this because I got tired of looking up movies that are playing in my
local cinema and cross referencing them with IMDB to check the ratings.

This currently supports the two CinemaCity theatres in Sofia, Bulgaria.

Requirements
------------

- PHP 7.3

Installation
------------

```
$ git clone https://github.com/pfrenssen/cinemascraper.git
$ cd cinemascraper
$ composer install
```


Usage
-----

```
$ ./scrape cinemacity "Paradise Center" --date=2019-03-27 --api-key=<omdb api key>
+-----------------------------------+---------+-------------+--------+-------+-----------------------------------+-----------------------------------------------------------------------------+
| Movie                             | Runtime | Released    | Rating | Age   | Language                          | Screenings                                                                  |
+-----------------------------------+---------+-------------+--------+-------+-----------------------------------+-----------------------------------------------------------------------------+
| Alita: Battle Angel               | 2:02    | 14 Feb 2019 | 7.6    | PG-13 | English, Spanish                  | 14:20, 16:50, 19:20, 21:50                                                  |
| Bohemian Rhapsody                 | 2:14    | 02 Nov 2018 | 8.1    | PG-13 | English                           | 16:10                                                                       |
| Captain Marvel                    | 2:04    | 08 Mar 2019 | 6.9    | PG-13 | English                           | 13:15, 15:00, 15:50, 16:40, 17:30, 18:20, 19:10, 20:00, 20:50, 21:40, 22:30 |
| Cold Pursuit                      | 1:58    | 08 Feb 2019 | 6.5    | R     | English                           | 19:00, 21:20                                                                |
| Fighting With My Family           | 1:48    | 22 Feb 2019 | 7.6    | PG-13 | English                           | 15:10, 19:50, 22:00                                                         |
| Glass                             | 2:09    | 18 Jan 2019 | 7.0    | PG-13 | Spanish, English                  | 21:30                                                                       |
| Green Book                        | 2:10    | 16 Nov 2018 | 8.3    | PG-13 | English, Italian, Russian, German | 14:10, 16:45, 19:30, 22:10                                                  |
| Happy Death Day 2U                | 1:40    | 13 Feb 2019 | 6.7    | PG-13 | English                           | 16:30, 18:50                                                                |
| How to Train Your Dragon: The ... | 1:45    | 22 Feb 2019 | 7.9    | PG    | English                           | 13:30, 14:30, 16:00, 18:10                                                  |
| Queen's Corgi                     | 1:32    | 03 Apr 2019 | 5.4    | N/A   | English                           | 13:20, 15:30, 17:30, 19:30                                                  |
| Ralph Breaks the Internet         | 1:52    | 21 Nov 2018 | 7.2    | PG    | English                           | 13:50                                                                       |
| South Wind                        | 2:10    | 15 Nov 2018 | 8.4    | N/A   | Serbian                           | 20:40                                                                       |
| The Favourite                     | 1:59    | 21 Dec 2018 | 7.7    | R     | English                           | 17:20, 20:30                                                                |
| The Mule                          | 1:58    | 14 Dec 2018 | 7.1    | R     | English, Spanish                  | 14:10                                                                       |
+-----------------------------------+---------+-------------+--------+-------+-----------------------------------+-----------------------------------------------------------------------------+
```
