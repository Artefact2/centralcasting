SOURCES=$(shell find ../data -type f -name "*.php")

graph.svg: graph.dot Makefile
	dot -Tsvg $< > $@

graph.dot: $(SOURCES) parse
	./parse > $@

clean:
	rm -f graph.dot graph.svg

.PHONY: clean