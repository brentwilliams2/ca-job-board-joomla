# Usage:
#
# find ./ -type f -name "default.blade.php" -exec awk -i inplace -f /var/www/html/work/ca-job-board-joomla/scripts/text.awk {} \;

{DEFAULT = 1}

BEGINFILE {
  print FILENAME > "/dev/stderr"
}

/\.\/[[:alpha:]]*\/[[:alpha:]_]*\.blade\.php/ {
  DEFAULT = 0
}

DEFAULT {
  print $0
}

#ENDFILE {
  # print ""
#}

#END {}