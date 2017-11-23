#!/bin/sh

sudo -u postgres psql -h localhost -U fajose -d fajose < fajose.sql
