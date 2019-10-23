# Usage:
#
# find ./ -type f -name "default.blade.php" -exec awk -i inplace -f /var/www/html/work/ca-job-board-joomla/scripts/text.awk {} \;

{DEFAULT = 1}

/helper\.buttonwidgets\.addNew/ {
  print "    @if ($canUserAdd)"
  print "      @jhtml('helper.buttonwidgets.addNew', $this, $prefix, $crud)"
  print "    @endif"

  DEFAULT = 0
}

DEFAULT {
  print $0
}