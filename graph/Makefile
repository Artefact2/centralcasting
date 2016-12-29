SOURCES=$(shell find ../data -type f -name "*.php")

NPARTS=50
PCOUNT=1000
PARTS=$(shell seq 0 $(NPARTS))
DATAS=$(addprefix datap, $(addsuffix .json, $(PARTS)))

graph.svgz: graph.svg
	gzip --force --best --keep $<
	mv $<.gz $@

graph.svg: graph.dot
	dot -Tsvg $< > $@

graph.dot: data.json gendot
	./gendot $< > $@

data.json: $(DATAS)
	./mergedata $(DATAS) > $@

datap%.json: $(SOURCES) gendata
	./gendata $(PCOUNT) > $@

clean:
	rm -f graph.dot graph.svg graph.svgz data.json $(DATAS)

.PHONY: clean
