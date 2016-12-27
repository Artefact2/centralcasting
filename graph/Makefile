SOURCES=$(shell find ../data -type f -name "*.php")

graph.svg: graph.dot Makefile
	dot -Tsvg $< > $@

graph.dot: data.json gendot
	./gendot $< > $@

data.json: $(SOURCES) parse
	./parse > $@

clean:
	rm -f graph.dot graph.svg data.json

.PHONY: clean
